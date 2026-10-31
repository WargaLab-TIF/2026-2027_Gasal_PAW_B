<?php
$fruits = array("Avocado", "Blueberry", "Cherry", "Durian", "Elderberry", "Fig", "Grape", "Honeydew");

unset($fruits[1]);
$fruits = array_values($fruits);

echo "Data Blueberry dihapus.<br>";
echo 'fruits = ("' . $fruits[0] . '", "' . $fruits[1] . '", "' . $fruits[2] . '", "' . $fruits[3] . '", "' . $fruits[4] . '", "' . $fruits[5] . '", "' . $fruits[6] . '")<br>';

echo "Nilai dengan indeks tertinggi: " . $fruits[6];
?>