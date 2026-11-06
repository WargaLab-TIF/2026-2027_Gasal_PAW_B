<?php
$fruits = array("Avocado","Blueberry","Cherry");

$fruits[] = "Durian";
$fruits[] = "Elderberry";
$fruits[] = "Fig";
$fruits[] = "Grape";
$fruits[] = "Honeydew";

echo 'fruits = ( "' . $fruits[0] . '","' . $fruits[1] . '","' . $fruits[2] . '","' . $fruits[3] . '","' . $fruits[4] . '","' . $fruits[5] . '"."' . $fruits[6] . '"."' . $fruits[7] . '")';

$last = count($fruits) - 1;
echo "<br>". "Nilai dengan index tertinggi: " . $fruits[count($fruits) - 1];

?>