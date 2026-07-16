# Mood — Inspiration Gallery

Simple, minimal image gallery with infinite scroll.

## Features
- Latest or Random sort modes
- Infinite scroll (50 images per batch)
- Grid / Rotated presentation toggle
- Pinch-to-zoom on mobile (scale + rotate)
- Double-tap to download / share
- Responsive (mobile-first, 1–4 columns)
- PWA (add to home screen)
- Zero dependencies (vanilla JS + PHP)

## Setup

### 1. Clone
```bash
git clone https://github.com/nonlinear/mood
cd mood
```

### 2. Link your images
```bash
ln -s /path/to/your/pictures images
```

### 3. Serve locally
```bash
php -S localhost:3001 router.php
```

Open **http://localhost:3001**

## File Structure
```
mood/
├── index.php          # Gallery UI (vanilla JS)
├── api.php            # JSON endpoint (image list)
├── router.php         # PHP built-in server router
├── run-mood.sh        # Launch script
├── README.md
├── fonts/
├── icons/
├── static/            # Error pages (too-busy.html)
├── images/ → /path/to/pictures  # Symlink (you create this)
├── manifest.json      # PWA manifest
```

## Making it Public — Cloudflare Tunnel

This gallery runs on a private machine. To expose it safely to the internet
without opening any ports or revealing the origin IP, it uses a **Cloudflare
Tunnel** (formerly Argo Tunnel).

The chain is:

```
Visitor → Cloudflare (CDN + WAF) → cloudflared tunnel (outbound) → local PHP server
```

Key properties:
- The tunnel is a **reverse connection**: the machine connects out to Cloudflare.
  No port is opened in the firewall, no inbound connection ever reaches the machine.
- Cloudflare proxies all traffic, so the origin IP stays hidden.
- Adding rate limiting or access rules at Cloudflare keeps abuse away from your machine.
- If the tunnel drops, the machine is unreachable — there's no open port to scan.

This means you can serve a personal gallery from any computer (a Mac Studio, a
Raspberry Pi, a laptop) without needing a static IP, a VPS, or a DMZ.

## Notes

- Supports: JPG, PNG, GIF, WebP, AVIF
- No database needed (filesystem-based — the image directory is scanned on each request)
- Rate limiting built into router.php and nginx config (for production deployments)
