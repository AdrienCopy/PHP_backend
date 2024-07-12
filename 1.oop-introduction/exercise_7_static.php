<?php

declare(strict_types=1);

/* EXERCISE 7

Copy your solution from exercise 6

TODO: Make a static property in the Beverage class that can only be accessed from inside the class called address which has the value "Melkmarkt 9, 2000 Antwerpen".
TODO: Print the address without creating a new instant of the beverage class 2 times in two different ways.

Use typehinting everywhere!
*/

define("barname", "Het Vervolg");

class Beverage
{
    private static $adresse = "Melkmarkt 9, 2000 Anvers";
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

    public static function getAdresse(): string 
    {
        return self::$adresse . "<br>";
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
    public static function getAdresseBeer(): string 
    {
        return parent::getAdresse();
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
echo $duvel->getAdresse();
echo $duvel->getAdresseBeer();


?>