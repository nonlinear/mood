<?php
// Router for PHP built-in server.

// --- Config ---
$config = json_decode(file_get_contents(__DIR__ . '/config.json'), true);
$imagesDir = $config['imagesDir'] ?? 'images';

// --- Rate limit ---
$rateLimitFile = __DIR__ . '/.ratelimit.cache';
$rateLimitWindow = $config['rateLimit']['windowSeconds'] ?? 10;
$rateLimitMax = $config['rateLimit']['maxRequests'] ?? 30;

$clientIp = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
// Trust X-Forwarded-For from Caddy/Cloudflare
if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $forwardedIps = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    $clientIp = trim(end($forwardedIps));
}
$ipHash = hash('fnv1a32', $clientIp); // short hash, no privacy leak

$rateData = [];
if (file_exists($rateLimitFile)) {
    $contents = @file_get_contents($rateLimitFile);
    if ($contents !== false) {
        $rateData = json_decode($contents, true) ?? [];
    }
}

// Clean expired entries
$now = time();
foreach ($rateData as $hash => $timestamps) {
    $rateData[$hash] = array_filter($timestamps, fn($t) => $t > $now - $rateLimitWindow);
    if (empty($rateData[$hash])) {
        unset($rateData[$hash]);
    }
}

// Check current IP
$timestamps = $rateData[$ipHash] ?? [];
if (count($timestamps) >= $rateLimitMax) {
    // Rate limited — serve too-busy page
    http_response_code(429);
    $tooBusyFile = __DIR__ . '/static/too-busy.html';
    if (file_exists($tooBusyFile)) {
        readfile($tooBusyFile);
    } else {
        echo '<html><body><h1>I guess we\'re too famous</h1><p>We\'re an artisanal site, runinng local, and we can\'t hold too many people at once. Maybe tomorrow?</p></body></html>';
    }
    return true;
}

// Record this request
$timestamps[] = $now;
$rateData[$ipHash] = $timestamps;
@file_put_contents($rateLimitFile, json_encode($rateData), LOCK_EX);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Strip trailing slashes (but keep root /)
$path = rtrim($path, '/') ?: '/';

// Root → serve index.php
if ($path === '/') {
    require __DIR__ . '/index.php';
    return true;
}

// Explicitly allowed public files (executed)
$allowedPhp = [
    '/api.php',
];

// Static assets allowed
$allowedStatic = [
    '/manifest.json',
];

if (in_array($path, $allowedPhp)) {
    // Let PHP built-in server execute the .php file
    return false;
}

if (in_array($path, $allowedStatic)) {
    return false;
}

// Allow fonts/*
if (preg_match('#^/fonts/[a-zA-Z0-9_\-\.\s]+\.(otf|ttf|woff|woff2)$#', $path)) {
    return false;
}

// Allow icons/*
if (preg_match('#^/icons/[a-zA-Z0-9_\-\.]+\.(png|jpg|jpeg|svg|ico)$#', $path)) {
    return false;
}

// Allow static/*
if (preg_match('#^/static/[a-zA-Z0-9_\-\.]+\.(html|css|js)$#', $path)) {
    return false;
}

// Serve /images/* from the configured images directory
if (preg_match('#^/images/.+$#', $path)) {
    $file = __DIR__ . '/' . $imagesDir . '/' . basename($path);
    if (file_exists($file)) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $mimes = ['jpg'=>'image/jpeg','jpeg'=>'image/jpeg','png'=>'image/png','gif'=>'image/gif','webp'=>'image/webp','svg'=>'image/svg+xml'];
        if (isset($mimes[$ext])) header('Content-Type: ' . $mimes[$ext]);
        readfile($file);
        return true;
    }
    // 404
    http_response_code(404);
    echo 'Image not found';
    return true;
}

// Allow apple-touch-icon.png at root
if ($path === '/apple-touch-icon.png') {
    return false;
}

// Everything else → SPA fallback (serves index.php for routing)
require __DIR__ . '/index.php';
return true;
