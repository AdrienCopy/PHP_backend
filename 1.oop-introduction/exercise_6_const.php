<?php

declare(strict_types=1);

/* EXERCISE 6

Copy the classes of exercise 2.

TODO: Change the properties to private.
TODO: Make a const barname with the value 'Het Vervolg'.
TODO: Print the constant on the screen.
TODO: Create a function in beverage and use the constant.
TODO: Do the same in the beer class.
TODO: Print the output of these functions on the screen.
TODO: Make sure that every print is on a new line.

Use typehinting everywhere!
*/
define("barname", "Het Vervolg");

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
        return "This beverage is $this->temperature and $this->color.<br>";
    }
    public function barname(): string
    {
        return "Drink available at " . barname . "<br>";
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
    public function barnameBeer(): string
    {
        return "$this->name available at " . barname . "<br>";
    }
}

$duvel = new Beer("Duvel", 8.5, "blond", 3.5);
$bevergage1 = new Beverage("orange", 1.5);
$bevergage2 = new Beverage("black", 2, "hot");
$cola = new Beverage("black", 2);


echo $duvel->getInfo();
echo $duvel->getAlcoholPercentage();

echo $bevergage1->getInfo();
echo $bevergage2->getInfo();
echo $cola->getInfo();
echo barname . "<br>";
echo $cola->barname();
echo $duvel->barnameBeer();


?>