#!/bin/bash
phpdismod xdebug
mkdir -p /run/php
touch /etc/cron.d/cron
tail -F /var/log/apache2/* &
exec /usr/bin/supervisord
