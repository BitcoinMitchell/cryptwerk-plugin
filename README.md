# CryptWerk Plugin

[![Maintained](https://img.shields.io/maintenance/yes/2022?style=flat-square)](https://github.com/bitcoinmitchell/cryptwerk-plugin/pulse)
[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/bitcoinmitchell/cryptwerk-plugin/Validate/master?style=flat-square)](https://github.com/bitcoinmitchell/cryptwerk-plugin/actions)
[![GitHub License](https://img.shields.io/github/license/bitcoinmitchell/cryptwerk-plugin?color=brightgreen&style=flat-square)](https://github.com/bitcoinmitchell/cryptwerk-plugin/blob/master/LICENSE)
[![GitHub contributors](https://img.shields.io/github/contributors-anon/bitcoinmitchell/cryptwerk-plugin?style=flat-square)](https://github.com/bitcoinmitchell/cryptwerk-plugin/graphs/contributors)

[![PrestaShop module version](https://img.shields.io/badge/module%20version-0.3.5-brightgreen?style=flat-square)](https://github.com/bitcoinmitchell/cryptwerk-plugin/releases)
[![GitHub release (latest SemVer)](https://img.shields.io/github/v/release/bitcoinmitchell/cryptwerk-plugin?sort=semver&style=flat-square)](https://github.com/bitcoinmitchell/cryptwerk-plugin/releases)
[![GitHub all releases](https://img.shields.io/github/downloads/bitcoinmitchell/cryptwerk-plugin/total?style=flat-square)](https://github.com/bitcoinmitchell/cryptwerk-plugin/releases)

This is a CryptWerk plugin for PrestaShop. It converts your available products into a XML feed that CryptWerk can parse.

## Requirements

Please ensure that you meet the following requirements before installing this plugin.

+ You have a [CryptWerk account](https://cryptwerk.com/id/register/).
+ You are using PHP 7.3 or higher.
+ Your PrestaShop is version 1.7.7.0 or higher.
+ The intl, mbstring and simplexml PHP extensions are available.

## Usage

1. [Download the latest CryptWerk plugin](https://github.com/bitcoinmitchell/cryptwerk-plugin/releases).
2. Go to your PrestaShop store and upload the zip via `Modules > Module Manager > Upload a module`.
4. Click on `Catalog -> CryptWerk Feed`, which will redirect you to your proper `feed` URL.
5. Setup product sync within CryptWerk `Dashboard -> Synchronization & Import` using the `XML` type.
6. Done (now you just need to await moderator approval).

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the
[tags on this repository](https://github.com/BitcoinMitchell/docker-prestashop/tags).

## Contributing

Contributors looking to help out, before opening a pull request, please [create an issue](https://github.com/bitcoinmitchell/cryptwerk-plugin/issues/new/choose)
to get early feedback, discuss the best ways to tackle the problem and to ensure there is no work duplication.

## PrestaShop Support

PrestaShop support can be found through its official channels.

* [Homepage](https://www.prestashop.com)
* [Documentation](https://doc.prestashop.com)
* [Support Forums](https://www.prestashop.com/forums)

## License

Software, logo and designs are provided under [MIT License](LICENSE).
