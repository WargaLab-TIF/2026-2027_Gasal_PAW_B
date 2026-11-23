<?php
$fruits = array("Avocado", "Blueberry", "Cherry");

$arrlength = count($fruits);

for ($x = 1; $x <= 5; $x++) {
    array_push($fruits, "Buah Tambahan " . $x);
}

$arrlength = count($fruits);

echo "Panjang array saat ini: " . $arrlength . "<br>";

for ($x = 0; $x < $arrlength; $x++) {
    echo $fruits[$x] . "<br>";
}
?>