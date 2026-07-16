<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>mood.nonlinear.nyc is joyscrolling</title>
  
  <!-- PWA -->
  <link rel="manifest" href="/manifest.json">
  <meta name="theme-color" content="#000000">
  <link rel="apple-touch-icon" href="/icons/apple-touch-icon.png">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="mood.nonlinear">
  <style>
    @font-face {
      font-family: 'Compagnon';
      src: url('fonts/Compagnon-Bold.otf?v=2') format('opentype');
      font-weight: bold;
      font-style: normal;
    }

    @font-face {
      font-family: 'Violet Sans';
      src: url('fonts/VioletSans-Regular.otf?v=2') format('opentype');
      font-weight: normal;
      font-style: normal;
    }

    @font-face {
      font-family: 'Miratrix';
      src: url('fonts/Miratrix-Normal.otf?v=2') format('opentype');
      font-weight: normal;
      font-style: normal;
    }

    @font-face {
      font-family: 'Messages';
      src: url('fonts/Messages.ttf?v=2') format('truetype');
      font-weight: normal;
      font-style: normal;
    }

    @font-face {
      font-family: 'Mareta';
      src: url('fonts/Mareta.otf?v=2') format('opentype');
      font-weight: normal;
      font-style: normal;
    }

    @font-face {
      font-family: 'PP Right Didone';
      src: url('fonts/PP Right Didone - Spatial Regular.otf?v=2') format('opentype');
      font-weight: normal;
      font-style: normal;
    }

    @font-face {
      font-family: 'PP Monument Extended';
      src: url('fonts/PPMonumentExtended-Light.otf?v=2') format('opentype');
      font-weight: 300;
      font-style: normal;
    }

    @font-face {
      font-family: 'PP Hatton';
      src: url('fonts/PPHatton-Medium.otf?v=2') format('opentype');
      font-weight: normal;
      font-style: normal;
    }

    @font-face {
      font-family: 'Perfograma';
      src: url('fonts/Perfograma.otf?v=2') format('opentype');
      font-weight: normal;
      font-style: normal;
    }

    @font-face {
      font-family: 'Misto';
      src: url('fonts/Misto.otf?v=2') format('opentype');
      font-weight: normal;
      font-style: normal;
    }

    /* Disable text/image selection for smooth touch navigation */
    * {
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      -webkit-touch-callout: none;
    }

    /* Re-enable selection for text content if needed */
    input, textarea {
      -webkit-user-select: text;
      -moz-user-select: text;
      -ms-user-select: text;
      user-select: text;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root {
      --bg: #000000;
      --text: #ffffff;
      --text-dim: #888888;
      --border: #000000;
      --hover: #000000;
    }

    body {
      background: var(--bg);
      color: var(--text);
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Helvetica Neue", sans-serif;
      line-height: 1.5;
      overflow-x: hidden;
    }

    /* Gallery Grid */
    #gallery-container {
      padding: 0;
      max-width: 100%;
      display: flex;
      gap: 0;
    }

    #menu {
      background: #000000;
      width: 40px;
      flex-shrink: 0;
      display: flex;
      flex-direction: column;
      position: sticky;
      top: 0;
      z-index: 1000;
      overflow: visible;
      height: 100vh;
      height: 100dvh;
      isolation: isolate;
    }

    #menu::before,
    #menu::after {
      content: '';
      position: absolute;
      top: 0;
      bottom: 0;
      width: 1px;
      background-image: repeating-linear-gradient(
        to bottom,
        #ffffff 0,
        #ffffff 7px,
        transparent 7px,
        transparent 10px
      );
      background-size: 1px 10px;
      background-repeat: repeat-y;
      background-position: 0 var(--border-offset, 0px);
    }

    @keyframes border-slide-down {
      0% { background-position: 0 0; }
      100% { background-position: 0 10px; }
    }

    #menu::before {
      left: -1px;
    }

    #menu::after {
      right: -1px;
    }

    /* Mobile: hide left border when menu is first */
    @media (max-width: 600px) {
      #menu::before {
        display: none;
      }
    }

    #menu-top {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 10px;
      gap: 6px;
    }

    #menu-spacer {
      flex: 1;
    }

    #menu-bottom {
      position: relative;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 15px;
      padding-bottom: 20px;
      z-index: 100;
    }

    .menu-icon {
      width: 19px;
      height: 19px;
      cursor: pointer;
      transition: color 0.3s;
      user-select: none;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #666666;
      text-decoration: none;
      position: relative;
    }

    .menu-icon::after {
      content: attr(data-tooltip);
      position: absolute;
      left: calc(100% + 10px);
      top: 50%;
      background: #000000;
      color: #cccccc;
      font-family: -apple-system, BlinkMacSystemFont, sans-serif;
      font-size: 10px;
      font-weight: normal;
      text-transform: uppercase;
      white-space: nowrap;
      padding: 3px 7px;
      pointer-events: none;
      opacity: 0;
      transform: translateY(-50%) translateX(-5px);
      transition: opacity 0.2s, transform 0.2s;
      transition-delay: 0s;
      z-index: 9999;
    }

    .menu-icon:hover {
      color: #ffffff;
    }

    .menu-icon:hover::after {
      opacity: 1;
      transform: translateY(-50%) translateX(0);
      transition-delay: 0.5s;
    }

    .menu-icon svg {
      width: 100%;
      height: 100%;
    }

    .menu-icon.tooltip-clicked::after {
      opacity: 0 !important;
      transition: none !important;
    }

    .menu-icon.active {
      color: #ffffff;
    }

    #menu-bottom h1 {
      font-family: 'Compagnon', -apple-system, BlinkMacSystemFont, sans-serif;
      font-size: 24px;
      font-weight: bold;
      letter-spacing: 0;
      line-height: 1.5;
      margin: 0 0 -10px -10px;
      writing-mode: vertical-rl;
      transform: rotate(180deg);
      white-space: nowrap;
      color: #ffffff;
    }

    .gallery-column {
      flex: 1;
      background: #000000;
      display: flex;
      flex-direction: column;
    }

    /* Mobile: menu first, only col-1 visible */
    @media (max-width: 600px) {
      #menu { order: 0; }
      .gallery-column[data-col="1"] { order: 1; display: flex; }
      .gallery-column[data-col="2"],
      .gallery-column[data-col="3"],
      .gallery-column[data-col="4"] { display: none; }
    }

    /* Small: col-1, menu, col-2 visible */
    @media (min-width: 601px) and (max-width: 1024px) {
      .gallery-column[data-col="1"] { order: 0; display: flex; }
      #menu { order: 1; }
      .gallery-column[data-col="2"] { order: 2; display: flex; }
      .gallery-column[data-col="3"],
      .gallery-column[data-col="4"] { display: none; }
    }

    /* Medium: col-1, menu, col-2, col-3 visible */
    @media (min-width: 1025px) and (max-width: 1599px) {
      .gallery-column[data-col="1"] { order: 0; display: flex; }
      #menu { order: 1; }
      .gallery-column[data-col="2"] { order: 2; display: flex; }
      .gallery-column[data-col="3"] { order: 3; display: flex; }
      .gallery-column[data-col="4"] { display: none; }
    }

    /* Large: col-1, menu, col-2, col-3, col-4 visible */
    @media (min-width: 1600px) {
      .gallery-column[data-col="1"] { order: 0; display: flex; }
      #menu { order: 1; }
      .gallery-column[data-col="2"] { order: 2; display: flex; }
      .gallery-column[data-col="3"] { order: 3; display: flex; }
      .gallery-column[data-col="4"] { order: 4; display: flex; }
    }

    .gallery-item {
      position: relative;
      cursor: default;
      overflow: hidden;
      border-radius: 0;
      background: #000000;
      transition: none;
      break-inside: avoid;
      margin-bottom: 0;
      display: flex;
      justify-content: center;
      align-items: flex-start;
    }

    .gallery-item::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(
        90deg,
        var(--border) 0%,
        var(--hover) 50%,
        var(--border) 100%
      );
      background-size: 200% 100%;
      animation: shimmer 1.5s infinite;
      opacity: 0;
      transition: opacity 0.3s;
      pointer-events: none;
    }

    .gallery-item:has(img.loading)::before {
      opacity: 1;
    }

    @keyframes shimmer {
      0% { background-position: 200% 0; }
      100% { background-position: -200% 0; }
    }

    .gallery-item img {
      width: 90%; /* Almost full width, subtle rotation won't crop */
      height: auto;
      display: block;
      transition: transform 0.2s ease-out;
      transform-origin: 0 0;
      cursor: default;
    }

    .gallery-item img.loading {
      background: transparent;
      min-height: 200px;
      opacity: 0.3;
    }

    .gallery-item img.loaded {
      opacity: 1;
    }

    .gallery-item img.loaded {
      transition: transform-origin 0s;
    }

    /* Hover zoom on desktop */
    @media (hover: hover) {
      .gallery-item:hover img.loaded {
        transform: scale(2.0);
      }
    }

    /* Presentation: grid mode (no rotation, full width) */
    body.presentation-grid .gallery-item img {
      width: 100%;
    }
    body.presentation-grid .gallery-item:hover img.loaded {
      transform: scale(1.05);
    }
    .gallery-column[data-col="1"] {
      padding-right: 5px;
    }
    .gallery-column[data-col="2"] {
      padding-left: 5px;
    }

    /* Menu divider */
    .menu-divider {
      width: 19px;
      height: 1px;
      background: #ffffff;
      margin: 4px 0;
    }

    /* Fullscreen - removed */

    /* Loading - removed, using per-image skeleton */


  </style>
</head>
<body>
<div id="gallery-container">
    <div class="gallery-column" data-col="1"></div>
    <div id="menu">
      <div id="menu-top">
        <!-- Presentation toggle: inactive = rotated, active = grid -->
        <div class="menu-icon" id="iconGrid" data-tooltip="Grid view">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M4 8h4V4H4v4zm6 12h4v-4h-4v4zm-6 0h4v-4H4v4zm0-6h4v-4H4v4zm6 0h4v-4h-4v4zm6-10v4h4V4h-4zm-6 4h4V4h-4v4zm6 6h4v-4h-4v4zm0 6h4v-4h-4v4z"/>
          </svg>
        </div>
        <div class="menu-divider" style="height:10px;background:#000000;"></div>
        <!-- Source group: reloads page -->
        <div class="menu-icon active" id="iconRandom" data-tooltip="Sort by random">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
          </svg>
        </div>
        <div class="menu-icon" id="iconLatest" data-tooltip="Sort by latest">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
            <path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
          </svg>
        </div>
      </div>
      <div id="menu-spacer"></div>
      <div id="menu-bottom">
        <a href="https://nonlinear.nyc" class="menu-icon" id="iconGlobe" data-tooltip="nonlinear.nyc" target="_blank" rel="noopener">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="transform:rotate(-90deg)">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
          </svg>
        </a>
        <h1>mood.nonlinear.nyc</h1>
      </div>
    </div>
    <div class="gallery-column" data-col="2"></div>
    <div class="gallery-column" data-col="3"></div>
    <div class="gallery-column" data-col="4"></div>
  </div>

  <script>
    let mode = 'random';
    let offset = 0;
    let loading = false;
    let hasMore = true;
    let randomSeed = Math.floor(Math.random() * 1000000); // New seed each page load

    const columns = [
      document.querySelector('.gallery-column[data-col="1"]'),
      document.querySelector('.gallery-column[data-col="2"]'),
      document.querySelector('.gallery-column[data-col="3"]'),
      document.querySelector('.gallery-column[data-col="4"]')
    ];

    let columnIndex = 0;

    function getActiveColumnCount() {
      const width = window.innerWidth;
      if (width < 601) return 1;
      if (width < 1025) return 2;
      if (width < 1600) return 3;
      return 4;
    }

    // Scroll-driven border animation
    let borderOffset = 0;
    let lastScrollY = window.scrollY;
    const menu = document.getElementById('menu');
    window.addEventListener('scroll', () => {
      const delta = window.scrollY - lastScrollY;
      lastScrollY = window.scrollY;
      borderOffset = (borderOffset + delta) % 10;
      menu.style.setProperty('--border-offset', borderOffset + 'px');
    }, { passive: true });

    // Source toggle (reloads content)
    const iconRandom = document.getElementById('iconRandom');
    const iconLatest = document.getElementById('iconLatest');
    
    function switchMode(isRandom) {
      if (isRandom) {
        iconRandom.classList.add('active');
        iconLatest.classList.remove('active');
        mode = 'random';
        randomSeed = Math.floor(Math.random() * 1000000);
      } else {
        iconRandom.classList.remove('active');
        iconLatest.classList.add('active');
        mode = 'latest';
      }
      columns.forEach(col => col.innerHTML = '');
      columnIndex = 0;
      offset = 0;
      hasMore = true;
      loadImages();
    }
    
    iconRandom.addEventListener('click', () => switchMode(true));
    iconLatest.addEventListener('click', () => switchMode(false));

    // Presentation toggle (no reload — just reskins existing images)
    const iconGrid = document.getElementById('iconGrid');
    let presentation = 'rotated';

    iconGrid.addEventListener('click', () => {
      if (presentation === 'rotated') {
        presentation = 'grid';
        iconGrid.classList.add('active');
        iconGrid.classList.add('tooltip-clicked');
        iconGrid.dataset.tooltip = 'Rotated view';
        document.body.classList.add('presentation-grid');
        document.querySelectorAll('.gallery-item img.loaded').forEach(img => {
          img.style.transform = 'rotate(0deg)';
        });
      } else {
        presentation = 'rotated';
        iconGrid.classList.remove('active');
        iconGrid.classList.add('tooltip-clicked');
        iconGrid.dataset.tooltip = 'Grid view';
        document.body.classList.remove('presentation-grid');
        document.querySelectorAll('.gallery-item img.loaded').forEach(img => {
          const rot = img.dataset.originalRotation || 0;
          img.style.transform = `rotate(${rot}deg)`;
        });
      }
    });

    iconGrid.addEventListener('mouseleave', () => iconGrid.classList.remove('tooltip-clicked'));

    // Load images
    async function loadImages() {
      if (loading || !hasMore) return;
      loading = true;

      try {
        const url = mode === 'random' 
          ? `api.php?mode=${mode}&offset=${offset}&limit=50&seed=${randomSeed}`
          : `api.php?mode=${mode}&offset=${offset}&limit=50`;
        const response = await fetch(url);
        const data = await response.json();

        if (data.images && data.images.length > 0) {
          data.images.forEach(img => {
            const item = document.createElement('div');
            item.className = 'gallery-item';
            
            // Set aspect ratio to reserve space before loading
            if (img.width && img.height) {
              item.style.aspectRatio = `${img.width} / ${img.height}`;
            }
            
            const imgEl = document.createElement('img');
            
            // Load full image directly (no thumbnail)
            imgEl.dataset.src = img.full;
            imgEl.className = 'loading';
            imgEl.alt = 'Inspiration';
            imgEl.loading = 'lazy';
            
            // Intersection Observer: Load when near viewport
            const observer = new IntersectionObserver((entries) => {
              entries.forEach(entry => {
                if (entry.isIntersecting) {
                  // Subtle random rotation for organic feel (cards being dealt)
                  const randomRotation = (Math.random() - 0.5) * 5; // -2.5° to +2.5° (half range)
                  
                  // Start below (no scale animation - images are already 70% in CSS)
                  imgEl.style.transform = `translateY(25px) rotate(${randomRotation}deg)`;
                  imgEl.style.opacity = '0';
                  
                  imgEl.src = img.full;
                  imgEl.onload = () => {
                    imgEl.className = 'loaded';
                    const rot = presentation === 'grid' ? 0 : randomRotation;
                    imgEl.style.transition = 'transform 0.4s ease-out, opacity 0.4s ease-out';
                    imgEl.style.transform = `translateY(0) rotate(${rot}deg)`;
                    imgEl.style.opacity = '1';
                    imgEl.dataset.originalRotation = randomRotation;
                  };
                  observer.unobserve(imgEl);
                }
              });
            }, { rootMargin: '200px' });
            
            observer.observe(imgEl);
            
            // Double tap to download or share (iOS)
            let lastTap = 0;
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
            
            imgEl.addEventListener('click', async (e) => {
              if (!imgEl.classList.contains('loaded')) return;
              
              const currentTime = new Date().getTime();
              const tapLength = currentTime - lastTap;
              
              if (tapLength < 300 && tapLength > 0) {
                // Double tap detected
                e.preventDefault();
                e.stopPropagation();
                
                // iOS: Use native share sheet
                if (isIOS && navigator.share) {
                  try {
                    // Fetch image as blob for sharing
                    const response = await fetch(img.full);
                    const blob = await response.blob();
                    const file = new File([blob], img.full.split('/').pop() || 'image.jpg', { type: blob.type });
                    
                    await navigator.share({
                      files: [file],
                      title: 'mood.nonlinear'
                    });
                  } catch (err) {
                    // Fallback to download if share fails
                    const link = document.createElement('a');
                    link.href = img.full;
                    link.download = img.full.split('/').pop() || 'image.jpg';
                    link.style.display = 'none';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                  }
                } else {
                  // Desktop/Android: Download
                  const link = document.createElement('a');
                  link.href = img.full;
                  link.download = img.full.split('/').pop() || 'image.jpg';
                  link.style.display = 'none';
                  document.body.appendChild(link);
                  link.click();
                  document.body.removeChild(link);
                }
              }
              
              lastTap = currentTime;
            });
            
            // Magnifying glass effect on hover/touch (only when loaded)
            let isTouching = false;
            const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
            
            // Helper function for magnifier positioning
            function updateMagnifier(touch) {
              const rect = item.getBoundingClientRect();
              const x = (touch.clientX - rect.left) / rect.width;
              const y = (touch.clientY - rect.top) / rect.height;
              imgEl.style.transformOrigin = `${x * 100}% ${y * 100}%`;
            }
            
            // Mouse events (desktop only)
            if (!isTouchDevice) {
              item.addEventListener('mouseenter', () => {
                if (!imgEl.classList.contains('loaded')) return;
                // Flatten and zoom to 2x (slower transition)
                imgEl.style.transition = 'transform 0.4s ease-out';
                imgEl.style.transform = 'translateY(0) rotate(0deg) scale(2.222)'; // 2x of 90% = 2.222x
              });
              
              item.addEventListener('mousemove', (e) => {
                if (!imgEl.classList.contains('loaded')) return;
                const rect = item.getBoundingClientRect();
                const x = (e.clientX - rect.left) / rect.width;
                const y = (e.clientY - rect.top) / rect.height;
                imgEl.style.transformOrigin = `${x * 100}% ${y * 100}%`;
              });
              
              item.addEventListener('mouseleave', () => {
                // Return to organic rotation at 70%
                const originalRotation = imgEl.dataset.originalRotation || 0;
                imgEl.style.transition = 'transform 0.5s ease-out';
                imgEl.style.transform = `translateY(0) rotate(${originalRotation}deg) scale(1)`;
                imgEl.style.transformOrigin = '0 0';
              });
            }
            
            // Touch events (mobile only) - pinch to zoom + rotate
            if (isTouchDevice) {
              let initialDistance = 0;
              let initialAngle = 0;
              let initialScale = 1;
              let currentScale = 1;
              let currentRotation = 0;
              let resetTimeout = null;
              
              function getDistance(touch1, touch2) {
                const dx = touch2.clientX - touch1.clientX;
                const dy = touch2.clientY - touch1.clientY;
                return Math.sqrt(dx * dx + dy * dy);
              }
              
              function getAngle(touch1, touch2) {
                const dx = touch2.clientX - touch1.clientX;
                const dy = touch2.clientY - touch1.clientY;
                return Math.atan2(dy, dx) * (180 / Math.PI);
              }
              
              function getPinchCenter(touch1, touch2, rect) {
                const centerX = (touch1.clientX + touch2.clientX) / 2;
                const centerY = (touch1.clientY + touch2.clientY) / 2;
                const x = (centerX - rect.left) / rect.width;
                const y = (centerY - rect.top) / rect.height;
                return { x, y };
              }
              
              function scheduleReset() {
                clearTimeout(resetTimeout);
                resetTimeout = setTimeout(() => {
                  const originalRotation = imgEl.dataset.originalRotation || 0;
                  currentScale = 1;
                  currentRotation = 0;
                  // Return to organic rotation at 70% (scale(1) in CSS)
                  imgEl.style.transform = `translateY(0) rotate(${originalRotation}deg) scale(1)`;
                  imgEl.style.transformOrigin = '0 0';
                  imgEl.style.transition = 'transform 1s ease-out';
                  setTimeout(() => {
                    imgEl.style.transition = '';
                  }, 1000);
                }, 2000);
              }
              
              item.addEventListener('touchstart', (e) => {
                if (!imgEl.classList.contains('loaded')) return;
                
                if (e.touches.length === 2) {
                  // Only flatten when starting pinch
                  e.preventDefault();
                  clearTimeout(resetTimeout);
                  initialDistance = getDistance(e.touches[0], e.touches[1]);
                  initialAngle = getAngle(e.touches[0], e.touches[1]);
                  initialScale = currentScale;
                  // Flatten for pinch interaction
                  imgEl.style.transition = 'transform 0.2s ease-out';
                  imgEl.style.transform = 'translateY(0) rotate(0deg) scale(1)';
                }
                // Single touch does nothing - keep organic rotation
              });
              
              item.addEventListener('touchmove', (e) => {
                if (!imgEl.classList.contains('loaded')) return;
                if (e.touches.length === 2) {
                  e.preventDefault();
                  
                  const distance = getDistance(e.touches[0], e.touches[1]);
                  const angle = getAngle(e.touches[0], e.touches[1]);
                  const scale = (distance / initialDistance) * initialScale;
                  
                  // Allow zoom from 0.5x to 4x
                  currentScale = Math.max(0.5, Math.min(4, scale));
                  
                  // Calculate rotation delta
                  currentRotation = angle - initialAngle;
                  
                  const rect = item.getBoundingClientRect();
                  const center = getPinchCenter(e.touches[0], e.touches[1], rect);
                  
                  imgEl.style.transformOrigin = `${center.x * 100}% ${center.y * 100}%`;
                  imgEl.style.transform = `scale(${currentScale}) rotate(${currentRotation}deg)`;
                }
              });
              
              item.addEventListener('touchend', (e) => {
                if (e.touches.length < 2) {
                  scheduleReset();
                }
              });
            }
            
            item.appendChild(imgEl);
            
            // Distribute to columns in round-robin
            const activeColumns = getActiveColumnCount();
            const targetColumn = columns[columnIndex % activeColumns];
            targetColumn.appendChild(item);
            columnIndex++;
          });

          offset += data.images.length;
          hasMore = data.images.length === 50;
        } else {
          hasMore = false;
        }
      } catch (error) {
        console.error('Error loading images:', error);
        hasMore = false;
      }

      loading = false;
    }

    // Infinite scroll
    let scrollTimeout;
    window.addEventListener('scroll', () => {
      clearTimeout(scrollTimeout);
      scrollTimeout = setTimeout(() => {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 500) {
          loadImages();
        }
      }, 100);
    });

    // Initial load
    loadImages();
  </script>
</body>
</html>
