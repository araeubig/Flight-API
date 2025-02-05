#!/bin/sh

XDEBUG_MODE=off
export XDEBUG_MODE

if [ -f /etc/conf.d/wordpress ]; then
    # shellcheck source=/dev/null
    . /etc/conf.d/wordpress
fi

: "${WP_DOMAIN:=localhost}"
: "${WP_MULTISITE:=""}"
: "${WP_MULTISITE_TYPE:=subdirectory}"
: "${WP_PERSIST_UPLOADS:=""}"
: "${WP_INSTALL_LANGUAGES:=}"
: "${WP_INSTALL_PLUGINS:=}"
: "${WP_ENVIRONMENT:=site}"
: "${WP_THEMETEST:=}"

if [ "${CODESPACES:-}" = 'true' ] && [ "${CLOUDENV_ENVIRONMENT_ID:-}" = 'null' ] && [ -n "${GITHUB_TOKEN}" ]; then
    echo "Prebuild detected, skipping WordPress setup"
    exit 0
fi

if [ -n "${CODESPACE_NAME}" ] && [ -n "${GITHUB_CODESPACES_PORT_FORWARDING_DOMAIN}" ]; then
    WP_DOMAIN="${CODESPACE_NAME}-80.${GITHUB_CODESPACES_PORT_FORWARDING_DOMAIN}"
fi

db_host=127.0.0.1
db_admin_user=root
wp_url="http://${WP_DOMAIN}"
wp_title="WordPress Development Site"

if [ -n "${WP_MULTISITE}" ]; then
    multisite_domain="${WP_DOMAIN}"
    multisite_type="${WP_MULTISITE_TYPE}"
    if [ -n "${CODESPACE_NAME}" ]; then
        multisite_type="subdirectories"
    fi
else
    multisite_domain=
    multisite_type=
fi

MY_UID="$(id -u)"
MY_GID="$(id -g)"

if [ -n "${RepositoryName}" ]; then
    base=/workspaces/${RepositoryName}
else
    base=$(pwd)
fi

if [ "${WP_ENVIRONMENT}" = "site" ]; then
    WS_DIRS="client-mu-plugins images languages plugins themes client-config"
else
     WS_DIRS="client-config"
fi

for i in $WS_DIRS; do
    if [ ! -e "${base}/${i}" ]; then
        mkdir -p "${base}/${i}"
    fi
    sudo rm -rf "/wp/wp-content/${i}"
    sudo ln -sf "${base}/${i}" "/wp/wp-content/${i}"
done

# if ! [ "${WP_ENVIRONMENT}" = "site" ]; then
#     for i in ${base}/*; do
#         if [[ -d "$i" ] && ! [ ${WS_DIRS[@]} =~ ${i##*/} ]]; then
#             echo "${i##*/}"
#             sudo ln -sfn "${base}/${i##*/}" "/wp/wp-content/"${WP_ENVIRONMENT}/${i##*/}"
#         fi
#     done
# fi

if [ "${WP_ENVIRONMENT}" != "site" ]; then
    for i in "$base"/*/; do
        target=$(basename "$i")
        case "$target" in
            (client-mu-plugins|images|languages|plugins|themes|client-config|vendor);;
            (*)
            source=${i%%/};
            environment="${WP_ENVIRONMENT}"s
            sudo ln -sf "$source" "/wp/wp-content/$environment/$target"
            ;;
        esac
    done
fi

if [ -n "${WP_PERSIST_UPLOADS}" ]; then
    sudo install -d -o "${MY_UID}" -g "${MY_GID}" -m 0755 /workspaces/uploads
    ln -sf /workspaces/uploads /wp/wp-content/uploads
else
    sudo install -d -o "${MY_UID}" -g "${MY_GID}" -m 0755 /wp/wp-content/uploads
fi

sudo install -d -o "${MY_UID}" -g "${MY_GID}" /wp/config /wp/logs

export WP_USERNAME="wordpress"
export WP_PASSWORD="wordpress"
export WP_DATABASE="wordpress"
export WP_DBHOST="${db_host}"

# shellcheck disable=SC2016
envsubst '$WP_USERNAME $WP_PASSWORD $WP_DATABASE $WP_DBHOST' < /usr/share/wordpress/wp-config.php.tpl > /wp/config/wp-config.php
if [ -n "${multisite_domain}" ]; then
    wp config set WP_ALLOW_MULTISITE true --raw  --config-file=/wp/config/wp-config.php
    wp config set MULTISITE true --raw  --config-file=/wp/config/wp-config.php
    wp config set DOMAIN_CURRENT_SITE "${multisite_domain}"  --config-file=/wp/config/wp-config.php
    wp config set PATH_CURRENT_SITE /  --config-file=/wp/config/wp-config.php
    wp config set SITE_ID_CURRENT_SITE 1 --raw  --config-file=/wp/config/wp-config.php
    wp config set BLOG_ID_CURRENT_SITE 1 --raw  --config-file=/wp/config/wp-config.php
    if [ "${multisite_type}" != "subdomain" ]; then
        wp config set SUBDOMAIN_INSTALL false --raw --config-file=/wp/config/wp-config.php
    else
        wp config set SUBDOMAIN_INSTALL true --raw --config-file=/wp/config/wp-config.php
    fi
fi
wp config shuffle-salts --config-file=/wp/config/wp-config.php

echo "Waiting for MySQL to come online..."
second=0
while ! mysqladmin ping -u "${db_admin_user}" -h "${db_host}" --silent && [ "${second}" -lt 60 ]; do
    sleep 1
    second=$((second+1))
done
if ! mysqladmin ping -u "${db_admin_user}" -h "${db_host}" --silent; then
    echo "ERROR: mysql has failed to come online"
    exit 1;
fi

{
    echo "CREATE USER IF NOT EXISTS '${WP_USERNAME}'@'localhost' IDENTIFIED BY '${WP_PASSWORD}';";
    echo "CREATE USER IF NOT EXISTS 'netapp'@'localhost' IDENTIFIED BY '${WP_PASSWORD}';";
    echo "CREATE DATABASE IF NOT EXISTS ${WP_DATABASE};"
    echo "GRANT ALL ON ${WP_DATABASE}.* TO '${WP_USERNAME}'@'localhost';"
    echo "GRANT ALL ON ${WP_DATABASE}.* TO 'netapp'@'localhost';"
} | mysql -h "${db_host}" -u "${db_admin_user}"

echo "Checking for WordPress installation..."
if ! wp core is-installed >/dev/null 2>&1; then
    echo "No installation found, installing WordPress..."

    wp db clean --yes 2> /dev/null
    if [ -n "${multisite_domain}" ]; then
        if [ "${multisite_type}" = "subdomain" ]; then
            type="--subdomains"
        else
            type=""
        fi
        # shellcheck disable=SC2248,SC2086 # see https://github.com/Automattic/wp-codespaces/issues/86
        wp core multisite-install \
            --path=/wp \
            --url="${wp_url}" \
            --title="${wp_title}" \
            --admin_user="admin" \
            --admin_email="admin@localhost.local" \
            --admin_password="password" \
            --skip-email \
            --skip-plugins \
            --skip-themes \
            ${type} \
            --skip-config
    else
        wp core install \
            --path=/wp \
            --url="${wp_url}" \
            --title="${wp_title}" \
            --admin_user="admin" \
            --admin_email="admin@localhost.local" \
            --admin_password="password" \
            --skip-email \
            --skip-plugins \
            --skip-themes
        
        wp theme install twentytwentyfour --activate
        
        if [ "${WP_INSTALL_PLUGINS}" = "true" ]; then
            echo "Installing plugins..."
            for Plugin in ${PLUGINS}; do
                wp plugin install "$Plugin" --activate
            done
        fi

        if [ "${WP_INSTALL_LANGUAGES}" = "true" ]; then
            echo "Installing languages..."
            for Language in ${LANGUAGES}; do
                wp language core install "$Language"
                # wp language theme install twentytwentythree "$Language"
                # if [ "${WP_INSTALL_PLUGINS}" = "true" ]; then
                #     for Plugin in ${PLUGINS}; do
                #         wp language plugin install "$Plugin" "$Language"
                #     done
                # fi
            done
        fi

        # if [ "${WP_THEMETEST}" = "true" ]; then
        #     echo "Installing Theme Unit Test Data"
        #     wp plugin install wordpress-importer --activate
        #     wget -q https://raw.githubusercontent.com/WordPress/theme-test-data/master/themeunittestdata.wordpress.xml -O testdata.xml
        #     wp import testdata.xml --authors=create --quiet
        #     rm testdata.xml
        # fi
    fi

    wp user add-cap 1 view_query_monitor

    run-parts /var/lib/wordpress/postinstall.d
else
    echo "WordPress already installed"
fi

if [ ! -f "${HOME}/.local/share/wp-codespaces/login/010-wplogin.sh" ]; then
    export WP_URL="${wp_url}"
    # shellcheck disable=SC2016
    envsubst '$WP_URL' < /usr/share/wordpress/010-wplogin.tpl > "${HOME}/.local/share/wp-codespaces/login/010-wplogin.sh"
fi

exit 0
