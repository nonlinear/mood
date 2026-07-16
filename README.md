# Mood — Inspiration Gallery

Simple, minimal image gallery with infinite scroll.
Zero dependencies (vanilla JS + PHP).

## Download

```bash
git clone https://github.com/nonlinear/mood
cd mood
```

## 🎨 Personalize

Edite `config.json`:

```json
{
  "imagesDir": "images",
  "siteName": "mood",
  "siteUrl": "http://localhost:3001",
  "siteLink": "https://nonlinear.nyc",
  "rateLimit": {
    "maxRequests": 30,
    "windowSeconds": 10
  }
}
```

| Campo | O que faz |
|---|---|
| `imagesDir` | Caminho das suas imagens (relativo ao projeto ou absoluto) |
| `siteName` | Nome que aparece no `<title>`, PWA e menu |
| `siteUrl` | URL base pro manifesto PWA |
| `siteLink` | Link que o ícone do globo abre |
| `rateLimit` | Máx de requisições por IP por janela de tempo |

## ▶️ Rodar

```bash
php -S localhost:3001 router.php
```

Open **http://localhost:3001**

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
├── config.json        # Settings (images directory, site name, rate limit, fonts)
├── index.php          # Gallery UI (vanilla JS)
├── api.php            # JSON endpoint (image list)
├── router.php         # PHP built-in server router + rate limit
├── run-mood.sh        # Launch script
├── fonts/             # Typefaces (bundled)
├── icons/             # PWA icons
├── static/            # Error pages (too-busy.html)
├── images/            # Your pictures (defined in config.json, not in repo)
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
