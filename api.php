<?php
header('Content-Type: application/json');

$imagesDir = __DIR__ . '/images';
$mode = $_GET['mode'] ?? 'latest';
$offset = (int)($_GET['offset'] ?? 0);
$limit = min((int)($_GET['limit'] ?? 50), 100);

$extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
$images = [];

foreach ($extensions as $ext) {
    $images = array_merge($images, glob("$imagesDir/*.$ext"));
    $images = array_merge($images, glob("$imagesDir/*." . strtoupper($ext)));
}

if ($mode === 'random') {
    $sessionSeed = $_GET['seed'] ?? null;
    if (!$sessionSeed) {
        shuffle($images);
    } else {
        mt_srand((int)$sessionSeed);
        shuffle($images);
    }
} else {
    usort($images, function($a, $b) {
        return filemtime($b) - filemtime($a);
    });
}

$total = count($images);
$images = array_slice($images, $offset, $limit);

$response = [];
foreach ($images as $imagePath) {
    $filename = basename($imagePath);
    $relativePath = 'images/' . $filename;

    $dimensions = @getimagesize($imagePath);
    $width = $dimensions ? $dimensions[0] : null;
    $height = $dimensions ? $dimensions[1] : null;

    $response[] = [
        'thumb' => $relativePath,
        'full' => $relativePath,
        'width' => $width,
        'height' => $height
    ];
}

echo json_encode([
    'images' => $response,
    'total' => $total,
    'offset' => $offset,
    'limit' => $limit
]);
