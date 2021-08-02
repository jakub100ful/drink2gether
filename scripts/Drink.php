<?php

include_once 'HTMLDom.php';

class Drink {
    /**
     * The product to be price checked
     *
     * @var string
     */
    protected $name;
    protected $ingredients;
    protected $price;

    public function __construct(string $name, array $ingredients)
    {
        $this->name = $name;
        $this->ingredients = $ingredients;
    }

    private function getProductList(array $ingredientArray) :array
    {
        $productList = [];

        foreach($this->html->find('.product-listing') as $productListing) {
            $item['brand']     = $productListing->find('a div._brand', 0)->plaintext;
            $item['name']    = $productListing->find('a div._name', 0)->plaintext;

            $pricePerItem = $productListing->find('a div._price div._per-item', 0)->plaintext;

            preg_match('/\d+\.?\d*/', $pricePerItem, $matches);
            $price = $matches[0];
            $pricePer100m = floatval($price);

            // For prices per liter, convert to price per 100m
            if(str_contains($pricePerItem, "per ltr")){
                $pricePer100m = (floatval($price))/10;
            }

            $item['pricePer100m'] = $pricePer100m;

            $productList[] = $item;
        }

        return $productList;

    }

    private function getIngredientsProductList() :void
    {
        $ingredientsProductList = [];
        foreach($this->ingredients as $ingredientArray){
            $ingredientProductList = $this->getProductList($ingredientArray);
            $ingredientsProductList[] = $ingredientProductList;
        }
    }

    private function getDrinkPrice() :void
    {
        // TODO: Function that calculates overall drink price AND price per serving
    }

}