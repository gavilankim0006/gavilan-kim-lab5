#!/bin/bash
set -e

PORT="${PORT:-80}"

# Render (and similar hosts) inject $PORT. Point Apache at it.
if [ -f /etc/apache2/ports.conf ]; then
    sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
fi

if [ -f /etc/apache2/sites-available/000-default.conf ]; then
    sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/000-default.conf
fi

exec apache2-foreground
