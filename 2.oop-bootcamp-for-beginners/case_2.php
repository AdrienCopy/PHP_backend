<?php
class Product
{
    private $name;
    private $price;
    private $quantity;
    private $valeurTaxe;
    private $taxe;

    public function __construct(string $name, float $price, float $quantity, float $valeurTaxe)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->valeurTaxe = $valeurTaxe;
        $this->taxe = $this->price * $this->valeurTaxe;
    }
    public function setDiscount(float $discount): self 
    {
        $discount = $discount / 100;
        $this->price -= $discount;
        $this->taxe = $this->price * $this->valeurTaxe;
        return $this;
    }

    public function getPrice(): float 
    {
        return $this->price;
    }

    public function getQuantity(): int 
    {
        return $this->quantity;
    }

    public function getTotalPrice(): float 
    {
        return $this->price * $this->quantity;
    }

    public function getTax(): float 
    {
        return $this->taxe * $this->quantity;
    }

    public function getTotalPriceDutyFree(): float 
    {
        return $this->getTotalPrice() - $this->getTax();
    }
}

class Basket {
    private $products = [];

    public function addProduct(Product $product): void 
    {
        $this->products[] = $product;
    }
    public function getTotalPrice(): float 
    {
        $totalPrice = 0;
        foreach ($this->products as $product) {
            $totalPrice += $product->getTotalPrice();
        }
        return $totalPrice;
    }
    public function getTotalTax(): float {
        $totalTax = 0;
        foreach ($this->products as $product) {
            $totalTax += $product->getTax();
        }
        return $totalTax;
    }
    public function getTotalPriceDutyFree(): float {
        $totalPriceDutyFree = 0;
        foreach ($this->products as $product) {
            $totalPriceDutyFree += $product->getTotalPriceDutyFree();
        }
        return $totalPriceDutyFree;
    }
}

$bananas = new Product("Banana", 1, 6, 0.06);
$apples = new Product("Apple", 1.5, 3, 0.06);
$bottlesOfWine =  new Product("Bottle of wine", 10, 2, 0.21);

$bananas = $bananas->setDiscount(50);
$apples = $apples->setDiscount(50);

$basket = new Basket();
$basket->addProduct($bananas);
$basket->addProduct($apples);
$basket->addProduct($bottlesOfWine);

$totalPrice = $basket->getTotalPrice();
$totalTax = $basket->getTotalTax();
$totalPriceDutyFree = $basket->getTotalPriceDutyFree();

echo "Le prix total du panier sans taxes est de: " . $totalPriceDutyFree . "€<br>";
echo "Le montant total des taxes est de: " . $totalTax . "€<br>";
echo "Le prix total du panier est de: " . $totalPrice . "€<br>";



