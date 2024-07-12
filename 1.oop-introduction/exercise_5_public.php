<?php

declare(strict_types=1);

/* EXERCISE 5

Copy the class of exercise 1.

TODO: Change the properties to private.
TODO: Fix the errors without using getter and setter functions.
TODO: Change the price to 3.5 euro and print it also on the screen on a new line.
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

    public function getInfo(): string
    {
        return "This beverage is $this->temperature and $this->color and the price is $this->price $.<br>";
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}

$bevergage1 = new Beverage("orange", 1.5);
$bevergage2 = new Beverage("black", 2, "hot");
$cola = new Beverage("black", 2);

echo $bevergage1->getInfo();
echo $bevergage2->getInfo();
echo $cola->getInfo();

$cola->setPrice(3.5);
echo $cola->getInfo();

?>