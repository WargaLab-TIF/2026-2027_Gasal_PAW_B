<?php
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");

$hasil = array();
foreach ($weight as $nama => $berat) {
    $hasil[] = '"' . $nama . '"=>"' . $berat . '"';
}
echo "weight = (" . implode(", ", $hasil) . ")<br><br>";

$keys = array_keys($weight);
$arrlength = count($weight);

for ($x = 0; $x < $arrlength; $x++) {
    echo $keys[$x] . " is " . $weight[$keys[$x]] . " kg.<br>";
}
?>