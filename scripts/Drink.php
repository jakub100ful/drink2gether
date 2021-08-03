<?php

include_once 'HTMLDom.php';
include_once 'Ingredient.php';

class Drink {
    /**
     * The product to be price checked
     *
     * @var string
     */
    public $name;
    public $ingredientsArray;
    public $price;
    public $recipe;

    public function __construct(string $name, array $ingredients, array $recipe=[])
    {
        $this->name = $name;
        $this->ingredients = $ingredients;
        $this->recipe = $ingredients;
    }

    private function setIngredientsArray() :void
    {
        // GET PRODUCT

        foreach($this->ingredients as $ingredient){
            $productList = [];
            $url = 'https://www.trolley.co.uk/search/?q='.$ingredient[0];
            $html = file_get_html($url);
    
            foreach($html->find('.product-listing') as $productListing) {
                $ingredientBrand     = $productListing->find('a div._brand', 0)->plaintext;
                $ingredientName    = $productListing->find('a div._name', 0)->plaintext;
    
                $ingredientPricePerItem = $productListing->find('a div._price div._per-item', 0)->plaintext;
    
                preg_match('/\d+\.?\d*/', $ingredientPricePerItem, $matches);
                $price = $matches[0];
                $ingredientPricePer100m = floatval($price);
    
                // For prices per liter, convert to price per 100m
                if(strpos($ingredientPricePer100m, "per ltr")){
                    $ingredientPricePer100m = (floatval($price))/10;
                }
        
                $productList[] = new Ingredient($ingredientBrand, $ingredientName, $ingredientPricePer100m);
            }
        }

        $this->ingredientsArray = $productList;
    }

    public function getIngredientsArray() :array{
        if(isset($this->ingredientsArray)){
            return($this->ingredientsArray);
        }else{
            $this->setIngredientsArray();
            return($this->ingredientsArray);
        }
    }

    public function getIngredientsProductList() :array
    {
        $ingredientsProductList = [];
        foreach($this->ingredients as $ingredientArray){
            $ingredientProductList = $this->getProductList($ingredientArray);
            $ingredientsProductList[] = $ingredientProductList;
        }
        
        return $ingredientsProductList;
    }

    private function getDrinkPrice() :void
    {
        // TODO: Function that calculates overall drink price AND price per serving
    }

}