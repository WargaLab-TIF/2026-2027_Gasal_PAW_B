<?php
$fruits = array("Avocado", "Blueberry", "Cherry");

$fruits[] = "Durian";
$fruits[] = "Elderberry";
$fruits[] = "Fig";
$fruits[] = "Grape";
$fruits[] = "Honeydew";

unset($fruits[1]);

echo "Data Blueberry dihapus.<br>";
echo 'fruits = ( ';

foreach ($fruits as $fruit) {
    echo '"' . $fruit . '", ';
}

echo ')<br>';
echo "Nilai dengan indeks tertinggi: " . $fruits[count($fruits) ];
?>