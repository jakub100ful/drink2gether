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

}