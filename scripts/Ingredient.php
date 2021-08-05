<?php

class Ingredient {
    /**
     * The name of ingredient
     * @var string
     * The amount of ingredient
     * @var int
     * The unit of the ingredient amount
     * @var string
     * The price of ingredient
     * @var float
     */
    public $name;
    public $amount;
    public $unit;
    public $price;

    public function __construct(string $name, float $amount, float $price, string $unit = "ml")
    {
        $this->name = $name;
        $this->amount = $amount;
        $this->price = $price;
        $this->unit = $unit;
    }

    // GETS THE DRINK PROPERTIES
    public function classifyUnit($measurementString) :void
    {
        $measurementList = explode(" ", strtolower($measurementString));

        if(in_array($measurementList,"ml")){
            $this->unit = "ml";
        }else if(in_array($measurementList,"oz")){
            $this->unit = "oz";
        }else if(in_array($measurementList,"cup") || in_array($measurementList,"cups")){
            $this->unit = "cup";
        }else if(in_array($measurementList,"tsp") || in_array($measurementList,"teaspoons")){
            $this->unit = "tsp";
        }else if(in_array($measurementList,"tblsp") || in_array($measurementList,"tablespoons")){
            $this->unit = "tblsp";
        }else{
            $this->unit = "other";
        }


    }

}