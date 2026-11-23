<?php
$fruits = array("Avocado", "Blueberry", "Cherry");
for ($i = 0; $i < 5; $i++) {
    $fruits[] = "Buah Tambahan " . $i+1;
}
$arrlength = count($fruits);
echo "Panjang array saat ini: " . $arrlength . "<br>";
for ($x = 0; $x < $arrlength; $x++) {
    echo $fruits[$x] . "<br>";
}
?>
