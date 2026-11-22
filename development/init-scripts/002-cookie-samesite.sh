#!/bin/sh
# Cross-site POSTs returning to the HTTPS shop may omit SameSite=Lax cookies.
# None+Secure is required for those hops when the shop is on HTTPS/tunnel.
set -eu

if [ "${PS_PROTOCOL:-}" != "https" ] && [ "${SSL_REDIRECT:-}" != "true" ] && [ -z "${NGROK_TUNNEL_AUTO_DETECT:-}" ]; then
	echo "* Skipping cookie SameSite tweak (local HTTP stack)"
	exit 0
fi

echo "* Setting PS_COOKIE_SAMESITE=None for HTTPS/tunnel..."

mysql -h"${MYSQL_HOST:-mysql}" -P"${MYSQL_PORT:-3306}" -u"${MYSQL_USER:-prestashop}" -p"${MYSQL_PASSWORD:-prestashop}" "${MYSQL_DATABASE:-prestashop}" <<'SQL'
DELETE FROM `ps_configuration` WHERE `name` = 'PS_COOKIE_SAMESITE';
INSERT INTO `ps_configuration` (`id_shop_group`, `id_shop`, `name`, `value`, `date_add`, `date_upd`)
VALUES (NULL, NULL, 'PS_COOKIE_SAMESITE', 'None', NOW(), NOW());
SQL

echo "* PS_COOKIE_SAMESITE=None (re-login to the back office after this)"
