#!/bin/sh

set -e

PATH=/usr/local/bin:/usr/local/sbin:/bin:/sbin:/usr/bin:/usr/sbin

if [ "$(id -u || true)" -ne 0 ]; then
    echo 'Script must be run as root. Use sudo, su, or add "USER root" to your Dockerfile before running this script.'
    exit 1
fi

if [ -z "${_REMOTE_USER}" ] || [ "${_REMOTE_USER}" = "root" ]; then
    THE_USER="${CONTAINER_USER:-www-data}"
else
    THE_USER="${_REMOTE_USER}"
fi

HOME_DIR="$(getent passwd "${THE_USER}" | cut -d: -f6)"

install -d -D -m 0755 -o "${THE_USER}" -g "${THE_USER}" "${HOME_DIR}/.local/share/wp-codespaces"
install -d -D -m 0755 -o "${THE_USER}" -g "${THE_USER}" "${HOME_DIR}/.local/share/wp-codespaces/login"

install -m 0644 -o "${THE_USER}" -g "${THE_USER}" .bashrc "${HOME_DIR}/.bashrc"
install -m 0644 -o "${THE_USER}" -g "${THE_USER}" 001-welcome.sh "${HOME_DIR}/.local/share/wp-codespaces/login/001-welcome.sh"
