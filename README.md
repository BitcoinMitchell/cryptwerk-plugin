# CryptWerk Plugin

[![Maintained](https://img.shields.io/maintenance/yes/2026?style=flat-square)](https://github.com/bitcoinmitchell/cryptwerk-plugin/pulse)
[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/bitcoinmitchell/cryptwerk-plugin/validate.yml?style=flat-square)](https://github.com/bitcoinmitchell/cryptwerk-plugin/actions)
[![GitHub License](https://img.shields.io/github/license/bitcoinmitchell/cryptwerk-plugin?color=brightgreen&style=flat-square)](https://github.com/bitcoinmitchell/cryptwerk-plugin/blob/master/LICENSE)
[![GitHub contributors](https://img.shields.io/github/contributors-anon/bitcoinmitchell/cryptwerk-plugin?style=flat-square)](https://github.com/bitcoinmitchell/cryptwerk-plugin/graphs/contributors)

[![PrestaShop module version](https://img.shields.io/badge/module%20version-0.6.0-brightgreen?style=flat-square)](https://github.com/bitcoinmitchell/cryptwerk-plugin/releases)
[![GitHub release (latest SemVer)](https://img.shields.io/github/v/release/bitcoinmitchell/cryptwerk-plugin?sort=semver&style=flat-square)](https://github.com/bitcoinmitchell/cryptwerk-plugin/releases)
[![GitHub all releases](https://img.shields.io/github/downloads/bitcoinmitchell/cryptwerk-plugin/total?style=flat-square)](https://github.com/bitcoinmitchell/cryptwerk-plugin/releases)

This is a CryptWerk plugin for PrestaShop. It converts your available products into an XML feed that CryptWerk can parse.

## Features

+ The module exposes a `/module/cryptwerk/feed` endpoint that outputs all in-stock products as XML.
+ Each product includes: ID, title, link, price, description, categories, image, and brand (if available).
+ The feed is automatically updated as your catalog changes.
+ Adds a `CryptWerk Feed` tab under Catalog in PrestaShop admin

## Requirements

Please ensure that you meet the following requirements before installing this plugin.

+ You have a [CryptWerk account](https://cryptwerk.com/id/register/).
+ You are using PHP 8.4 or higher.
+ Your PrestaShop is version 9.2.0 or higher.
+ The intl, mbstring and simplexml PHP extensions are available.

## Usage

1. [Download the latest CryptWerk plugin](https://github.com/bitcoinmitchell/cryptwerk-plugin/releases).
2. Go to your PrestaShop store and upload the zip via `Modules > Module Manager > Upload a module`.
3. Click on `Catalog -> CryptWerk Feed`, which will redirect you to your feed URL.
4. Setup product sync within CryptWerk `Dashboard -> Synchronization & Import` using the `XML` type and your feed URL.
5. Await moderator approval on CryptWerk.

## Development

If you want to work on the plugin, it is recommended to install/use the following:
- [Symfony CLI](https://symfony.com/doc/current/setup/symfony_cli.html) is required for Makefile and makes life easier.
- [Docker](https://docs.docker.com/get-started/get-docker/) and Docker Compose
- [PrestaShop Flashlight](https://github.com/PrestaShop/prestashop-flashlight)

See [development/README.md](development/README.md) for the full local stack guide.

### Quick start

1. Copy `development/.env.dist` to `development/.env` and adjust as needed.
2. Run `make dev-up` (or `make dev-tunnel` when you need a public HTTPS URL).
3. Access PrestaShop at [http://localhost:8000](http://localhost:8000) (on Windows the compose override uses [http://localhost:9080](http://localhost:9080)).

### Building and linting

- `make build` – Installs dependencies and builds `cryptwerk.zip` in the `build/` folder.
- `make lint` – Runs PHP CS Fixer and PHPCS for code style checks (CI covers PHP 8.4 / 8.5 / 8.6).
- `make clean` – Cleans build artifacts and vendor folders.

### Code structure

- `modules/cryptwerk/cryptwerk.php` – Main module class and PrestaShop integration
- `modules/cryptwerk/controllers/front/feed.php` – XML feed controller
- `modules/cryptwerk/src/Factory.php` – XML feed builder logic
- `modules/cryptwerk/config/routes.yml` – Custom routes
- `modules/cryptwerk/config/services.yml` – Admin controller services
- `development/` – Docker, environment, and helper scripts

### Autocomplete

- `development/autocomplete.php` provides PrestaShop class stubs for IDE autocompletion.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the
[tags on this repository](https://github.com/bitcoinmitchell/cryptwerk-plugin/tags).

## Contributing

Contributors looking to help out, before opening a pull request, please [create an issue](https://github.com/bitcoinmitchell/cryptwerk-plugin/issues/new/choose)
to get early feedback, discuss the best ways to tackle the problem and to ensure there is no work duplication.

## Security

Please report security issues privately via email. See [SECURITY.md](SECURITY.md) for details.

## PrestaShop Support

PrestaShop support can be found through its official channels.

* [Homepage](https://www.prestashop.com)
* [Documentation](https://doc.prestashop.com)
* [Support Forums](https://www.prestashop.com/forums)

## License

Software, logo and designs are provided under [MIT License](LICENSE).
