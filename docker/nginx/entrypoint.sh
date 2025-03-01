#!/bin/sh

envsubst '$PORT $HOST $PHP_HOST $PHP_PORT ' < /etc/nginx/templates/default.conf.template > /etc/nginx/conf.d/default.conf

exec "$@"