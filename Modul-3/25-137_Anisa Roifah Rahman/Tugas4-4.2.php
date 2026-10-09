<?php
$weight = array("Andy" => "70", "Barry" => "65", "Charlie" => "75");

echo "weight = ";
print_r($weight);

echo "<br><br>";

$nama = array_keys($weight);
$berat = array_values($weight);

$arrlength = count($weight);

for ($x = 0; $x < $arrlength; $x++) {
    echo $nama[$x] . " is " . $berat[$x] . " kg.<br>";
}
?>