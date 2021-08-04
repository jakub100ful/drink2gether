<?php

require_once 'Ingredient.php';

class Product extends Ingredient {
    /**
     * The product brand
     *
     * @var string
     */
    public $brand;

    public function __construct(string $name, int $amount, float $price, string $unit, string $brand)
    {
        parent::__construct($name, $amount, $price, $unit);
        $this->brand = $brand;
    }

}