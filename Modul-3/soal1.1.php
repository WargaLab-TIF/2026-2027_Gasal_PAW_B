<?php
$fruits = array("Avocado", "Blueberry", "Cherry");

$fruits[] = "Durian";
$fruits[] = "Elderberry";
$fruits[] = "Fig";
$fruits[] = "Grape";
$fruits[] = "Mango";

$indeksTerakhir = array_key_last($fruits);

foreach ($fruits as $value) {
    echo $value . "<br>";
}
echo "Nilai indeks tertinggi: " . $fruits[$indeksTerakhir];
?>