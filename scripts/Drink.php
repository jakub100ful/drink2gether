<?php

require_once 'HTMLDom.php';
require_once 'Ingredient.php';
require_once 'Product.php';

class Drink {
    /**
     * The product to be price checked
     *
     * @var string
     */
    public $name;
    public $ingredientsArray;
    public $productsArray;
    public $price;
    public $recipe;

    public function __construct(string $name, array $ingredients, array $recipe=[])
    {
        $this->name = $name;
        $this->ingredients = $ingredients;
        $this->recipe = $recipe;

        $this->setProductsArray();
        $this->setIngredientsArray();
        $this->setPrice();
    }

    
    // PRODUCTS LIST SETTER AND GETTER
    private function setProductsArray() :void
    {
        
        foreach($this->ingredients as $ingredient){
            $productList = [];
            $ingredientParsed = preg_replace('/\W+/', '-', strtolower(trim($ingredient[0])));
            $url = 'https://www.trolley.co.uk/search/?q='.$ingredientParsed;
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
        
                $productList[] = new Product($ingredientName, 100, $ingredientPricePer100m, "ml", $ingredientBrand);
            }
        }

        usort($productList, function ($item1, $item2) {
            return $item1->price <=> $item2->price;
        });

        $this->productsArray = $productList;
    }


    public function getProductsArray() :array{
        if(isset($this->productsArray)){
            return($this->productsArray);
        }else{
            $this->setProductsArray();
            return($this->productsArray);
        }
    }


    // INGREDIENTS ARRAY SETTER AND GETTER
    public function setIngredientsArray() :void{
        if (!isset($this->productsArray)){
            $this->setProductsArray();
        }
        
        $ingredientList = [];
        $index = 0;

        foreach($this->ingredients as $ingredient){
            // Ingredient is worked out
            $name = $ingredient[0];
            $price = $this->productsArray[$index]->price;
            $amount = str_replace("ml","",$ingredient[1]);
            $pricePerIngredient = ($price/100)*$amount;

            $ingredientList[] = new Ingredient($name, $amount, $pricePerIngredient);
            $index++;
        }

        $this->ingredientsArray = $ingredientList;
    }

    public function getIngredientsArray() :array{
        if(isset($this->ingredientsArray)){
            return($this->ingredientsArray);
        }else{
            $this->setIngredientsArray();
            return($this->ingredientsArray);
        }
    }

    // PRICE SETTER AND GETTER
    private function setPrice() :void
    {
        $price = 0.0;

        foreach($this->ingredientsArray as $ingredient){
            $price += $ingredient->price;
        }

        $this->price = $price;
    }

    public function getPrice() :int
    {
        if(isset($this->price)){
            return($this->price);
        }else{
            $this->setPrice();
            return($this->price);
        }
    }

    // GETS THE DRINK PROPERTIES
    public function getDrinkSummary() :void
    {
        print_r($this->name);
        print_r($this->ingredientsArray);
        print_r($this->price);
        print_r($this->recipe);
    }

}