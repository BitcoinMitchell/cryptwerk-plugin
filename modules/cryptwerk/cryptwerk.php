<?php

use CryptWerk\Constants;

if (!defined('_PS_VERSION_')) {
	exit;
}

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
	throw new RuntimeException('Missing autoload');
}

require_once __DIR__ . '/vendor/autoload.php';

/** @noinspection AutoloadingIssuesInspection */
class CryptWerk extends Module
{
	public $tabs = [
		[
			'name'              => 'CryptWerk Feed', // Fallback when the translation is unavailable
			'route_name'        => 'admin_cryptwerk_configure',
			'class_name'        => 'AdminCryptWerkConfigure',
			'parent_class_name' => 'AdminCatalog',
			'visible'           => true,
			'wording'           => 'CryptWerk Feed', // Translation key
			'wording_domain'    => 'Modules.CryptWerk.Admin', // Translation domain
		],
	];

	public function __construct()
	{
		$this->name                   = 'cryptwerk';
		$this->tab                    = 'administration';
		$this->version                = '0.5.0';
		$this->author                 = 'BitcoinMitchell';
		$this->ps_versions_compliancy = ['min' => Constants::MINIMUM_PS_VERSION, 'max' => _PS_VERSION_];
		$this->bootstrap              = true;

		parent::__construct();

		$this->displayName      = $this->trans('CryptWerk', [], 'Modules.CryptWerk.Admin');
		$this->description      = $this->trans('Converts your products into a valid CryptWerk feed.', [], 'Modules.CryptWerk.Front');
		$this->confirmUninstall = $this->trans('Are you sure you want to delete this module?', [], 'Modules.CryptWerk.Front');
	}

	public function install(): bool
	{
		if (!parent::install()) {
			return false;
		}

		if (version_compare(\PHP_VERSION, Constants::MINIMUM_PHP_VERSION, '<')) {
			$this->_errors[] = $this->trans([
				'key'        => sprintf('PHP version is too low. Expected %s or higher, received %s.', Constants::MINIMUM_PHP_VERSION, \PHP_VERSION),
				'parameters' => [],
				'domain'     => 'Admin.Modules.Notification',
			]);

			return false;
		}

		if (version_compare(_PS_VERSION_, Constants::MINIMUM_PS_VERSION, '<')) {
			$this->_errors[] = $this->trans([
				'key'        => sprintf('PrestaShop version is too low. Expected %s or higher, received %s.', Constants::MINIMUM_PS_VERSION, _PS_VERSION_),
				'parameters' => [],
				'domain'     => 'Admin.Modules.Notification',
			]);

			return false;
		}

		return true;
	}

	public function isUsingNewTranslationSystem(): bool
	{
		return true;
	}
}
