# Cryptwerk Plugin Development Environment

This repository provides a development environment for the Cryptwerk plugin, including Docker-based services and helper scripts.

## Prerequisites

- [Docker](https://www.docker.com/get-started) and Docker Compose installed

## Getting Started

1. **Clone the repository:**
   ```sh
   git clone https://github.com/BitcoinMitchell/cryptwerk-plugin.git
   cd cryptwerk-plugin
   ```

2. **Configure environment variables:**
   - Copy `.env.dist` to `.env` and adjust values as needed:
     ```sh
     cp development/.env.dist development/.env
     # Edit development/.env as required
     ```
   - For PrestaShop, edit `development/prestashop/prestashop.env` if needed.

3. **Choosing PrestaShop Flashlight Version:**
   - The development environment uses the [PrestaShop Flashlight](https://github.com/PrestaShop/prestashop-flashlight) Docker image.
   - You can select the version by setting the `PS_VERSION` variable in your `.env` file.
   - Example options (see commented lines in `.env.dist`):
     - `9.0.0-8.1-fpm-alpine-nginx` (default, PrestaShop 9.0.0, PHP 8.1, Nginx)
     - `8.2.0-8.1-fpm-alpine`
     - `8.1.1-8.1-fpm-alpine`
     - `8.0.5-8.1-fpm-alpine`
     - `1.7.7.8-7.2-fpm-alpine`
     - `1.7.8.11-7.2-fpm-alpine`
     - `1.6.1.11-7.1-fpm-alpine`
   - Adjust the version to match your testing needs.

4. **Start the development environment:**
   ```sh
   cd development
   docker compose up --d
   ```
   This will pull and start all required containers (e.g., PrestaShop, MariaDB, Ngrok).

5. **Access the services:**
   - PrestaShop: [http://localhost:8080](http://localhost:8080) (will redirect you to the proper Ngrok URL)

## Autocomplete

- `development/autocomplete.php` provides PHP autocompletion for IDEs.

## Troubleshooting

- Ensure all environment variables are set correctly.
- Check Docker logs for errors: `docker compose logs`
- For permission issues, try running Docker as administrator.

## License

See [LICENSE](../LICENSE) for details.
