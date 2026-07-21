#!/bin/bash
# Mood watchdog — keeps PHP server alive.
# Stays in foreground forever. Start via @reboot or launchd.

cd "$(dirname "$0")"

start_php() {
    /opt/homebrew/bin/php -S 127.0.0.1:3001 -t . ./router.php >> php-server.log 2>&1
}

start_php &
PHP_PID=$!

while true; do
    if ! kill -0 $PHP_PID 2>/dev/null; then
        echo "[$(date)] PHP died, restarting..." >> php-server.log
        start_php &
        PHP_PID=$!
    fi
    sleep 10
done
