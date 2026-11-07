<?php
$fruits = array("Avocado", "Blueberry", "Cherry");

$fruits[] = "Durian";
$fruits[] = "Elderberry";
$fruits[] = "Fig";
$fruits[] = "Grape";
$fruits[] = "Honeydew";

echo 'fruits = ( ';

foreach ($fruits as $fruit) {
    echo '"' . $fruit . '", ';
}

echo ')<br>';
echo "Nilai dengan indeks tertinggi: " . $fruits[count($fruits) - 1];
?>