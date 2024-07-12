<?php

declare(strict_types=1);

/* EXERCISE 2

TODO: Make class beer that extends from Beverage.
TODO: Create the properties name (string) and alcoholPercentage (float).
TODO: Foresee a construct that's allows us to use all the properties from beverage and that sets the values for name and alcoholpercentage.

Remember for now we will use properties and methods that can be accessed from everywhere.
TODO: Make a getAlcoholPercentage function which returns the alocoholPercentage.
TODO: Instantiate an object which represents Duvel. Make sure that the color is set to blond, the price equals 3.5 euro and the temperature to cold automatically.
TODO: Also the name equal to Duvel and the alcohol percentage to 8,5%
TODO: Print the getAlcoholPercentage 2 times on the screen in two different ways, print the color on the screen and the getInfo.

Make sure that each print is on a different line.
Try to get this error on the screen= Fatal error: Uncaught Error: Call to undefined method Beverage::getAlcoholPercentage() in /var/www/becode/workshop/exercise2.php on line 64
USE TYPEHINTING EVERYWHERE!
*/
class Beverage
{
    public $color;
    public $price;
    public $temperature;

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
}

class Beer extends Beverage
{
    public $name;
    public $alcoholpercentage;

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
        return "This beverage is $this->temperature and $this->color. <br>";
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
?>