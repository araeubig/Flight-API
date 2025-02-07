#!/bin/sh

set -e

PATH=/usr/local/bin:/usr/local/sbin:/bin:/sbin:/usr/bin:/usr/sbin

if [ "$(id -u || true)" -ne 0 ]; then
    echo 'Script must be run as root. Use sudo, su, or add "USER root" to your Dockerfile before running this script.'
    exit 1
fi

echo '(*) Installing nginx...'

if [ -z "${_REMOTE_USER}" ] || [ "${_REMOTE_USER}" = "root" ]; then
    NGINX_USER=nginx
else
    NGINX_USER="${_REMOTE_USER}"
fi

apk add --no-cache nginx

install -D -m 0755 -o root -g root service-run /etc/sv/nginx/run
install -d -m 0755 -o root -g root /etc/service
ln -sf /etc/sv/nginx /etc/service/nginx

install -d -D -m 0755 -o root -g root /etc/nginx/http.d /etc/nginx/conf.extra

install -m 0644 -o root -g root default.conf /etc/nginx/http.d/default.conf

sed -i "s/user nginx;/user ${NGINX_USER};/" /etc/nginx/nginx.conf
chown -R "${NGINX_USER}:${NGINX_USER}" /run/nginx /var/log/nginx /var/lib/nginx

echo 'Done!'
