<?php

declare(strict_types=1);

/* EXERCISE 4

Copy the code of exercise 3 to here and delete everything related to cola.

TODO: Make all properties protected.
TODO: Make all the other prints work without error without changing the beverage class.
TODO: Don't call getters in de child class.

USE TYPEHINTING EVERYWHERE!
*/

class Beverage
{
    protected $color;
    protected $price;
    protected $temperature;

    public function __construct(string $color, float $price, string $temperature = "cold")
    {
        $this->color = $color;
        $this->price = $price;
        $this->temperature = $temperature;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function getInfo(): string
    {
        return "This beverage is $this->temperature and $this->color.<br>";
    }
}

class Beer extends Beverage
{
    protected $name;
    protected $alcoholpercentage;

    public function __construct(string $name, float $alcoholpercentage, string $color, float $price, string $temperature = "cold")
    {
        $this->name = $name;
        $this->alcoholpercentage = $alcoholpercentage;
        parent::__construct($color, $price, $temperature);
    }

    public function getAlcoholPercentage(): string
    {
        return "$this->name = $this->alcoholpercentage % <br>";
    }

    public function getInfo(): string
    {
        return "This beverage is $this->temperature and $this->color.<br>";
    }

    private function beerInfo(): string
    {
        return "Hi i'm $this->name and have an alcochol percentage of $this->alcoholpercentage % and I have a $this->color color.<br>";
    }
    public function getBeerInfo(): string
    {
        return $this->beerInfo();
    }
        
}

$duvel = new Beer("Duvel", 8.5, "blond", 3.5);

echo $duvel->getInfo();
echo $duvel->getAlcoholPercentage();

$duvel->setColor("light");
echo $duvel->getInfo();
echo $duvel->getBeerInfo();
?>