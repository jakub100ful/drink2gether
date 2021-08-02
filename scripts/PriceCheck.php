<?php

include_once 'HTMLDom.php';

class PriceCheck {
    /**
     * The product to be price checked
     *
     * @var string
     */
    protected $product;

    public function __construct(string $product)
    {
        $this->product = $product;
        $this->url = 'https://www.trolley.co.uk/search/?q='.$this->product;
        $this->html = file_get_html($this->url);
        $this->productList = [];
    }

    public function setProductList() :void
    {
        foreach($this->html->find('.product-listing') as $productListing) {
            $item['brand']     = $productListing->find('a div._brand', 0)->plaintext;
            $item['name']    = $productListing->find('a div._name', 0)->plaintext;
            $item['pricePerItem'] = $productListing->find('a div._price div._per-item', 0)->plaintext;
            $this->productList[] = $item;
        }
    }

    public function getProductList() :array
    {
        return $this->productList;
    }
}