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
            $queriedSize = "70cl";
            $queriedAmountOfProducts = 5;
            $queriedStores = "2";
            $index = 0;
            $url = 'https://www.trolley.co.uk/search/?q='.$ingredientParsed.'&size='.$queriedSize.'&stores='.$queriedStores;
            $html = file_get_html($url);
    
            foreach($html->find('.product-listing') as $productListing) {
                if($index < $queriedAmountOfProducts){
                    // IF PRODUCT IS A LIQUID (HAS PRICE PER 100ML)
                    if($productListing->find('a div._price div._per-item', 0)){
                        $ingredientBrand     = $productListing->find('a div._brand', 0)->plaintext;
                        $ingredientName    = $productListing->find('a div._name', 0)->plaintext;
            
                        $ingredientPricePerItem = $productListing->find('a div._price div._per-item', 0)->plaintext;
            
                        preg_match('/\d+\.?\d*/', $ingredientPricePerItem, $matches);
                        $price = $matches[0];
                        $ingredientPricePer100m = floatval($price);
            
                        // For prices per liter, convert to price per 100m
                        if(strpos($ingredientPricePer100m, "per ltr")){
                            $ingredientPricePer100m = (floatval($price))/10;
                        }else if (strpos($ingredientPricePer100m, "per 100g")){
                            break;
                        }
                
                        $productList[] = new Product($ingredientName, 100, $ingredientPricePer100m, "ml", $ingredientBrand);
                    }
                    $index++;
                }else{
                    $index++;
                    break;
                }
                

            }

            usort($productList, function ($item1, $item2) {
                return $item1->price <=> $item2->price;
            });
    
            $this->productsArray[] = $productList;
        }
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
            $amount;
            $unit;

            if(strpos($ingredient[1],"ml")){
                $amount = str_replace("ml","",$ingredient[1]);
                $unit = "ml";
            }else if(strpos($ingredient[1],"oz")){
                $amount = str_replace("oz","",$ingredient[1]);
                $unit = "oz";
                $amount = eval("return $amount;"); 

                // Convert to decimal FIX THIS FOR FRACTIONS LIKE 1 1/4
                // if(strpos($amount, " ",-1)){
                //     $amountExploded = explode(" ", $amount);

                //     $amount = eval("return $amountExploded[1];"); 
                //     $amount += $amountExploded[0];
                // }
            }

            // NEED ANOTHER INDEX AFTER [$index] TO ACCESS THE N-TH PRODUCT OF THAT INGREDIENT
            $price = $this->productsArray[$index][0]->price;
            $pricePerIngredient = ($price/100)*$amount;

            $ingredientList[] = new Ingredient($name, $amount, $pricePerIngredient, $unit);
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
            if($ingredient->unit == "ml"){
                $price += $ingredient->price*$ingredient->amount;
            }else{
                $price += $ingredient->price*($ingredient->amount*28.41);
            }
        }

        $this->price = round($price,2);
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

    // TODO: GET TOTAL AMOUNT OF SERVINGS PER INGREDIENT SET

}