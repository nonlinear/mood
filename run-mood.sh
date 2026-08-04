#!/bin/bash
# Mood gallery — PHP built-in server, managed by launchd (com.nonlinear.mood-php).
# Kept in foreground so launchd tracks it via KeepAlive.
cd "$(dirname "$0")" || exit 1
exec /opt/homebrew/bin/php -S 127.0.0.1:3001 -t . ./router.php
