<?php

include_once 'HTMLDom.php';

class Ingredient {
    /**
     * The product to be price checked
     *
     * @var string
     */
    public $brand;
    public $name;
    public $amount;
    public $unit;
    public $price;

    public function __construct(string $brand, string $name, float $price)
    {
        $this->brand = $brand;
        $this->name = $name;
        $this->price = $price;
    }

}