<?php
$fruits = array("Avocado", "Blueberry", "Cherry");
$dataBaru = array("Durian", "Elderberry", "Fig", "Grape", "Mango");

for ($i = 0; $i < count($dataBaru); $i++) {
    $fruits[] = $dataBaru[$i];
}

echo "Panjang array: " . count($fruits) . "<br>";

for ($x = 0; $x < count($fruits); $x++) {
    echo $fruits[$x] . "<br>";
}
?>