# Mood — Inspiration Gallery

Simple, minimal image gallery with infinite scroll.

## Features
- ✅ Latest or Random mode
- ✅ Infinite scroll (50 images per batch)
- ✅ Grid / Rotated presentation toggle
- ✅ Pinch-to-zoom on mobile (scale + rotate)
- ✅ Double-tap to download / share
- ✅ Responsive (mobile-first, 1–4 columns)
- ✅ PWA (add to home screen)
- ✅ Zero dependencies (vanilla JS + PHP)

## Setup

### 1. Clone
```bash
git clone https://github.com/nonlinear/mood
cd mood
```

### 2. Link your images
```bash
# Create a symlink to wherever your pictures live
ln -s /path/to/your/pictures images
```

### 3. Serve locally
```bash
php -S localhost:3001 router.php
```

**Open:** http://localhost:3001

## File Structure
```
mood/
├── index.php          # Gallery UI (vanilla JS)
├── api.php            # JSON endpoint (image list)
├── router.php         # PHP built-in server router
├── run-mood.sh        # Launch script
├── README.md          # This file
├── fonts/             # Typefaces
├── icons/             # PWA icons
├── static/            # Error pages
├── images/ → /path/to/pictures  # Symlink (you create this)
├── manifest.json      # PWA manifest
```

## Performance

- **Initial load:** 50 images (~2-3 sec)
- **Infinite scroll:** Lazy loads next 50 via Intersection Observer
- **Thumbnails:** Full-size images served directly (no thumbnail gen needed)
- **Mode switch:** Instant (re-sorts, re-fetches from API)

## Notes

- Supports: JPG, PNG, GIF, WebP
- No database needed (filesystem-based)
- `sync-from-nas.sh` syncs from Synology NAS at `/Volumes/serve/media/pictures/inspiration`
