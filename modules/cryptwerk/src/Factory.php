<?php

namespace CryptWerk;

class Factory
{
	private \Context $context;

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
			// If the product is out of stock, don't even bother
			if (0 === \StockAvailable::getQuantityAvailableByProduct($item['id_product'], 0)) {
				continue;
			}

			$product = new \Product($item['id_product'], true, $id_lang, $id_shop);

			/** @var \SimpleXMLElement $xmlProduct */
			$xmlProduct = $xml->addChild('product');
			$xmlProduct->addChild('id', (string) $product->id);

			if (!empty($product->meta_title)) {
				$xmlProduct->addChild('title', \strip_tags((string) $product->meta_title));
			} elseif (!empty($product->name)) {
				$xmlProduct->addChild('title', \strip_tags((string) $product->name));
			} elseif (!empty($product->description_short)) {
				$xmlProduct->addChild('title', \strip_tags((string) $product->description_short));
			} elseif (!empty($product->description)) {
				$xmlProduct->addChild('title', \strip_tags((string) $product->description));
			}

			$xmlProduct->addChild('link', (string) $product->getLink($this->context));
			$xmlProduct->addChild('price', (string) $product->getPrice());

			if (!empty($product->meta_description)) {
				$xmlProduct->addChild('description', \strip_tags((string) $product->meta_description));
			} elseif (!empty($product->description_short)) {
				$xmlProduct->addChild('description', \strip_tags((string) $product->description_short));
			} elseif (!empty($product->description)) {
				$xmlProduct->addChild('description', \strip_tags((string) $product->description));
			}

			/** @var \SimpleXMLElement $xmlCategories */
			$xmlCategories = $xmlProduct->addChild('categories');
			foreach ($product->getCategories() as $category_id) {
				$category = new \Category($category_id, $id_lang);
				$xmlCategories->addChild('category', \strip_tags((string) $category->name));
			}

			$xmlProduct->addChild('image_link', $this->getImageLink($product));

			if (!empty($product->manufacturer_name)) {
				$xmlProduct->addChild('brand', \strip_tags((string) $product->manufacturer_name));
			}
		}

		return $xml;
	}

	private function getImageLink(\Product $product): string
	{
		$coverImage = \Product::getCover($product->id);
		if (!\is_array($coverImage) || empty($coverImage['id_image'])) {
			return '';
		}

		$rewrite = $product->link_rewrite ?? $product->name;

		return (string) $this->context->link->getImageLink((string) $rewrite, (int) $coverImage['id_image']);
	}
}
