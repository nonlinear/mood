# Mood — Inspiration Gallery

Simple, minimal image gallery with infinite scroll.
Zero dependencies (vanilla JS + PHP).
Like [mood.nonlinear.nyc](https://mood.nonlinear.nyc) but you bring your own image folder.

## Download

```bash
git clone https://github.com/nonlinear/mood
cd mood
```

## 🎨 Personalize

Edit `config.json`:

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

| Field | What it does |
|---|---|
| `imagesDir` | Path to your images (relative to project root, or absolute) |
| `siteName` | Name shown in `<title>`, PWA, and menu |
| `siteUrl` | Base URL for PWA manifest |
| `siteLink` | Link the globe icon in the menu opens |
| `rateLimit` | Max requests per IP per time window |

## ▶️ Run

```bash
php -S localhost:3001 router.php
```

Open **http://localhost:3001**

## 🌐 Making it public — Cloudflare Tunnel

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
