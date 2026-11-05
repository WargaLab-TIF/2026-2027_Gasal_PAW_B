<?php
$fruits = array("Avocado", "Blueberry", "Cherry", "Durian", "Elderberry", "Fig", "Grape", "Honeydew");

$key = array_search("Blueberry", $fruits);

if ($key !== false) {
    unset($fruits[$key]);
}

$fruits = array_values($fruits);

echo "Data Blueberry dihapus.<br>";
echo 'fruits = ( ';

for ($i = 0; $i < count($fruits); $i++) {
    echo '"' . $fruits[$i] . '"';

    if ($i < count($fruits) - 1) {
        echo ', ';
    }
}

echo ' )';
echo "<br>";
echo "Nilai dengan indeks tertinggi: " . $fruits[count($fruits) - 1];
?>