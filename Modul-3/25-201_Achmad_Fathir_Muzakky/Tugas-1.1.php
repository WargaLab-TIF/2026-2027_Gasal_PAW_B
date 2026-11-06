<?php
$fruits = array("Avocado", "Blueberry", "Cherry");
array_push($fruits, "Durian", "Elderberry", "fig", "Grape", "Honeydew");
$terakhir = count($fruits) -1;

echo "fruits = ";
foreach ($fruits as $key) {
    echo "$key ";
}

echo "<br>";
echo "Nilai dengan indeks tertinggi: " . $fruits[$terakhir];

?>