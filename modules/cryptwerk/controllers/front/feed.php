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
		echo new XmlResponse($this->factory->build()->asXML());
	}
}
