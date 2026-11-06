<?php
$fruits = array("Avocado", "Blueberry", "Cherry");
array_push($fruits, "Durian", "Elderberry", "fig", "Grape", "Honeydew");

unset($fruits[1]);
$fruits = array_values($fruits);

echo "Data Blueberry dihapus.<br>";
echo "fruits = ";
foreach ($fruits as $key) {
    echo "$key ";
}

echo "<br>Nilai dengan indeks tertinggi: ";
echo $fruits[count($fruits) - 1];

?>