# CryptWerk Plugin — Development Environment

Docker stack for local PrestaShop with optional ngrok and Mailpit for mail.

## TOC

<!-- toc -->

- [Prerequisites](#prerequisites)
- [Getting Started](#getting-started)
- [Make targets](#make-targets)
- [Ngrok tunnel](#ngrok-tunnel)
- [Mailpit](#mailpit)
- [Linting](#linting)
- [Autocomplete](#autocomplete)
- [Troubleshooting](#troubleshooting)
- [Directory Structure](#directory-structure)
- [License](#license)

<!-- tocstop -->

## Prerequisites

- [Docker](https://docs.docker.com/get-started/get-docker/) and [Docker Compose](https://docs.docker.com/compose/install)
- [Composer](https://getcomposer.org/) / [Symfony CLI](https://symfony.com/doc/current/setup/symfony_cli.html) (for `make install` / `make build`)
- An [ngrok](https://dashboard.ngrok.com/get-started/setup) authtoken if you need a public HTTPS URL

## Getting Started

1. Clone and enter the repo:
   ```sh
   git clone https://github.com/bitcoinmitchell/cryptwerk-plugin.git
   cd cryptwerk-plugin
   ```

2. Configure env:
   ```sh
   cp development/.env.dist development/.env
   ```
   Set `PS_VERSION` (see comments in `.env.dist` or [Flashlight tags](https://hub.docker.com/r/prestashop/prestashop-flashlight/tags)). Optionally edit `development/prestashop/prestashop.env`.

   Default image: `9.2.1-8.4-fpm-bookworm-nginx` (PrestaShop 9.2.1 + PHP 8.4). PrestaShop does not support PHP 8.6 yet; keep Flashlight on 8.4/8.5 until official images exist.

3. Start:
   ```sh
   make dev-up
   ```
   For a public HTTPS URL, use [`make dev-tunnel`](#ngrok-tunnel) instead.

4. Services (Linux/macOS defaults; Windows override remaps shop → `9080`, Mailpit → `9026`):
   - Storefront: [http://localhost:8000](http://localhost:8000)
   - Back office: [http://localhost:8000/admin-dev](http://localhost:8000/admin-dev) (`admin@prestashop.com` / `prestashop`)
   - Mailpit: [http://localhost:8026](http://localhost:8026)
   - Ngrok inspector (tunnel profile): [http://localhost:4040](http://localhost:4040)

5. Install the module: `make build`, then upload `build/cryptwerk.zip` in **Modules -> Module Manager -> Upload a module**.

   The module is not bind-mounted. After code changes, rebuild and re-upload (or copy files into `/var/www/html/modules/cryptwerk` in the container).

## Make targets

| Target | Purpose |
| --- | --- |
| `make dev-up` | Composer deps + start stack (no ngrok) |
| `make dev-tunnel` | Recreate PrestaShop + ngrok; prints public URL |
| `make dev-down` | Stop stack (including tunnel profile) |
| `make dev-logs` | Follow Compose logs |
| `make dev-reset` | Wipe volumes and start fresh |
| `make install` | Root Composer + module deps |
| `make build` | Build `build/cryptwerk.zip` |
| `make lint` / `make lint-fix` | Check / fix PHP style |

## Ngrok tunnel

1. Set `NGROK_AUTHTOKEN` in `development/.env`.
2. Leave `PS_DOMAIN` empty and keep `NGROK_TUNNEL_AUTO_DETECT=http://ngrok:4040` (see `.env.dist`).
3. Start:
   ```sh
   make dev-tunnel
   ```
   Use the printed PrestaShop ngrok URL for storefront testing. Inspector: [http://localhost:4040](http://localhost:4040).

## Mailpit

SMTP is pointed at Mailpit on start (`init-scripts/001-mailpit-smtp.sh`). UI: [http://localhost:8026](http://localhost:8026) (host port 8026 to avoid clashing with other local Mailpit instances; Windows uses 9026).

## Linting

CI uses PHP 8.4 / 8.5 / 8.6. Prefer running via Docker if your host PHP differs:

```sh
docker run --rm -v "$PWD:/app" -w /app php:8.4-cli bash -c 'make lint-fix'
docker run --rm -v "$PWD:/app" -w /app php:8.4-cli bash -c 'make lint'
```

## Autocomplete

`development/autocomplete.php` provides PrestaShop stubs for IDEs.

## Troubleshooting

- Logs: `make dev-logs`
- Shop URL becomes `localhost:800000`: clear `PS_DOMAIN`, keep tunnel auto-detect, then `make dev-tunnel`
- Code changes not visible: rebuild/re-upload the zip (no live mount)
- After tunnel start, re-login to the back office so the admin cookie is `SameSite=None` (set by `init-scripts/002-cookie-samesite.sh`)
- Windows cannot bind ports 8000/8026: `docker-compose.override.yml` remaps to 9080/9026

## Directory Structure

- `.env.dist` -> copy to `.env`
- `docker-compose.yml` / `docker-compose.tunnel.yml` / `docker-compose.override.yml`
- `init-scripts/` - Flashlight startup hooks (Mailpit SMTP, cookie SameSite for tunnels)
- `prestashop/`, `ngrok/` - service config
- `autocomplete.php` - IDE stubs

## License

See [LICENSE](../LICENSE).
