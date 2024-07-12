<?php

declare(strict_types=1);

/* EXERCISE 3

TODO: Copy the code of exercise 2 to here and delete everything related to cola.
TODO: Make all properties private.
TODO: Make all the other prints work without error.
TODO: After fixing the errors. Change the color of Duvel to light instead of blond and also print this new color on the screen after all the other things that were already printed (to be sure that the color has changed).
TODO: Create a new private method in the Beer class called beerInfo which returns "Hi i'm Duvel and have an alcochol percentage of 8.5 and I have a light color."

Make sure that you use the variables and not just this text line.

TODO: Print this method on the screen on a new line.

USE TYPEHINTING EVERYWHERE!
*/
class Beverage
{
    private $color;
    private $price;
    private $temperature;

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
    private $name;
    private $alcoholpercentage;

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
        return parent::getInfo();
    }

    private function beerInfo(): string
    {
        $color = $this->getColor();
        return "Hi i'm $this->name and have an alcochol percentage of $this->alcoholpercentage % and I have a $color color.<br>";
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