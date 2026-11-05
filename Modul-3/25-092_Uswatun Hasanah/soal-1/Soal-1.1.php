<?php
$fruits = array("Avocado", "Blueberry", "Cherry");

array_push($fruits, "Durian", "Elderberry", "Fig", "Grape", "Honeydew");

echo "fruits = ( ";
for ($x = 0; $x < count($fruits); $x++) {
    echo '"' . $fruits[$x] . '"';
    if ($x < count($fruits) - 1) {
        echo ", ";
    }
}
echo " )";
echo "<br>";
echo "Nilai dengan indeks tertinggi: " . $fruits[count($fruits) - 1];
?>