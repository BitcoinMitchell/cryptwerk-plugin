<?php

namespace CryptWerk;

class Factory
{
	/**
	 * @var \Context
	 */
	private $context;

	public function __construct()
	{
		$this->context = \Context::getContext();
	}

	public function build(): \SimpleXMLElement
	{
		$id_lang = $this->context->language->id;
		$id_shop = $this->context->shop->id;

		$xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8" ?><products></products>');

		$products = \Product::getProducts($id_lang, 0, 0, 'id_product', 'ASC', false, true);
		foreach ($products as $item) {
			$product = new \Product($item['id_product'], true, $id_lang, $id_shop);
			$product->loadStockData();

			$xmlProduct = $xml->addChild('product');
			$xmlProduct->addChild('id', $product->id);

			if (!empty($product->meta_title)) {
				$xmlProduct->addChild('title', strip_tags($product->meta_title));
			} elseif (!empty($product->name)) {
				$xmlProduct->addChild('title', strip_tags($product->name));
			} elseif (!empty($product->description_short)) {
				$xmlProduct->addChild('title', strip_tags($product->description_short));
			} elseif (!empty($product->description)) {
				$xmlProduct->addChild('title', strip_tags($product->description));
			}

			$xmlProduct->addChild('link', $product->getLink($this->context));
			$xmlProduct->addChild('price', $product->getPrice());

			if (!empty($product->meta_description)) {
				$xmlProduct->addChild('description', strip_tags($product->meta_description));
			} elseif (!empty($product->description_short)) {
				$xmlProduct->addChild('description', strip_tags($product->description_short));
			} elseif (!empty($product->description)) {
				$xmlProduct->addChild('description', strip_tags($product->description));
			}

			$xmlCategories = $xmlProduct->addChild('categories');
			foreach ($product->getCategories() as $category_id) {
				$category = new \Category($category_id, $id_lang);
				$xmlCategories->addChild('category', strip_tags($category->name));
			}

			$xmlProduct->addChild('image_link', $this->getImageLink($product));

			if (!empty($product->manufacturer_name) && 'Coins of Nakamoto' !== $product->manufacturer_name) {
				$xmlProduct->addChild('brand', strip_tags($product->manufacturer_name));
			}
		}

		return $xml;
	}

	private function getImageLink(\Product $product): string
	{
		$coverImage = \Product::getCover($product->id);

		return $this->context->link->getImageLink($product->link_rewrite ?? $product->name, (int) $coverImage['id_image']);
	}
}
