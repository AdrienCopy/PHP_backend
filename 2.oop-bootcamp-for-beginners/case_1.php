<?php
$bananas = [
    'name' => 'Banana',
    'price' => 1.0,
    'quantity' => 6,
    'taxe' => 1.0 * 0.06
];

$apples = [
    'name' => 'Apple',
    'price' => 1.5,
    'quantity' => 3,
    'taxe' => 1.5 * 0.06
];

$bottlesOfWine = [
    'name' => 'Bottle of wine',
    'price' => 10.0,
    'quantity' => 2,
    'taxe' => 10.0 * 0.21
];

$basket = [$bananas, $apples, $bottlesOfWine];

$totalPrice = 0;
$totalTax = 0;

foreach ($basket as $product) {
    $totalPrice += $product['price'] * $product['quantity'];
    $totalTax += $product['taxe'] * $product['quantity'];
}

echo "Le prix total du panier sans taxes est de: " . ($totalPrice - $totalTax) . "€<br>";
echo "Le montant total des taxes est de: " . $totalTax . "€<br>";
echo "Le prix total du panier est de: " . $totalPrice . "€<br>";

