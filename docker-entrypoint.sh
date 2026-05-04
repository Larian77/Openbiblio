#!/bin/sh
set -e

# Write the timezone from TZ env var so PHP and MySQL clocks match
echo "date.timezone = ${TZ:-UTC}" > /usr/local/etc/php/conf.d/timezone.ini

exec "$@"
