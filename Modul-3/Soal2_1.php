<?php
$fruits = array('Avocado', 'Blueberry', 'Cherry');

for ($x = 1; $x <= 5; $x++) {
    $fruits[] = 'Buah Tambahan ' . $x;
}

$arrlength = count($fruits);
echo "Panjang array saat ini: $arrlength <br><br>";

for ($x = 0; $x < $arrlength; $x++) {
    echo $fruits[$x];
    echo "<br>";
}
?>