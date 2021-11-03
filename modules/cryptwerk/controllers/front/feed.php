<?php

use CryptWerk\Component\HttpFoundation\XmlResponse;
use CryptWerk\Factory;

/** @noinspection AutoloadingIssuesInspection */
class CryptWerkFeedModuleFrontController extends \ModuleFrontController
{
	/**
	 * Enable SSL only.
	 *
	 * @var bool
	 */
	public $ssl = true;

	/**
	 * @var CryptWerk
	 */
	public $module;

	/**
	 * @var Factory
	 */
	private $factory;

	public function __construct()
	{
		parent::__construct();

		$this->factory = new Factory();
	}

	/**
	 * {@inheritdoc}
	 */
	public function display(): void
	{
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Content-type: text/xml');
		header('Pragma: public');
		header('Expires: 0');

		echo $this->factory->build()->asXML();
	}
}
