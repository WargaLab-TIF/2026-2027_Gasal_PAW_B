<?php
$weight = array("Andy" => "70", "Barry" => "65", "Charlie" => "75");
$nama = array("Andy", "Barry", "Charlie");

$arrlength = count($weight);

echo "weight = ( ";

for ($x = 0; $x < $arrlength; $x++) {
    echo $nama[$x] . " => " . $weight[$nama[$x]] . ", ";
}

echo ")<br><br>";

for ($x = 0; $x < $arrlength; $x++) {
    echo $nama[$x] . " is " . $weight[$nama[$x]] . " kg.<br>";
}
?>