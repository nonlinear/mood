#!/bin/bash
# Mood gallery - PHP built-in server managed by launchd
# This script stays in foreground so launchd can track it via KeepAlive
cd "$(dirname "$0")" && exec /opt/homebrew/bin/php -S 127.0.0.1:3001 -t . ./router.php
