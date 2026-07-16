# Mood — Inspiration Gallery

Simple, minimal image gallery with infinite scroll.
Zero dependencies (vanilla JS + PHP).

## Quick Start

```bash
git clone https://github.com/nonlinear/mood
cd mood

# Edit config.json — set your images directory
#   "imagesDir": "images"   → relative path from project root
ln -s /path/to/your/pictures images

# Serve locally
php -S localhost:3001 router.php
```

Open **http://localhost:3001**

## Customize

Edit `config.json`:

```json
{
  "imagesDir": "images",
  "siteName": "mood",
  "siteUrl": "http://localhost:3001",
  "rateLimit": {
    "maxRequests": 30,
    "windowSeconds": 10
  }
}
```

| Field | What it does |
|---|---|
| `imagesDir` | Directory (or symlink) with your images |
| `siteName` | Used in `<title>` and PWA name |
| `siteUrl` | Base URL for PWA manifest |
| `rateLimit` | Max requests per IP per time window |

## Features
- Latest or Random sort modes
- Infinite scroll (50 images per batch)
- Grid / Rotated presentation toggle
- Pinch-to-zoom on mobile (scale + rotate)
- Double-tap to download / share
- Responsive (1–4 columns)
- PWA (add to home screen)

## File Structure
```
mood/
├── config.json        # Settings (images directory, site name, rate limit)
├── index.php          # Gallery UI (vanilla JS)
├── api.php            # JSON endpoint (image list)
├── router.php         # PHP built-in server router + rate limit
├── run-mood.sh        # Launch script
├── fonts/
├── icons/
├── static/            # Error pages (too-busy.html)
├── images/ → ...      # Symlink to your pictures (not in repo)
├── manifest.json      # PWA manifest
```

## Making it Public — Cloudflare Tunnel

This gallery runs on a private machine. To expose it safely to the internet
without opening any ports or revealing the origin IP, it uses a **Cloudflare
Tunnel** (formerly Argo Tunnel).

```
Visitor → Cloudflare (CDN + WAF) → cloudflared tunnel (outbound) → local PHP server
```

- The tunnel is a **reverse connection**: the machine connects out to Cloudflare.
  No port is opened in the firewall, no inbound connection ever reaches the machine.
- Cloudflare proxies all traffic, so the origin IP stays hidden.
- Rate limiting at Cloudflare keeps abuse away from your machine.
- If the tunnel drops, the machine is unreachable — no open port to scan.

## Notes

- Supports: JPG, PNG, GIF, WebP
- No database needed (filesystem-based)
