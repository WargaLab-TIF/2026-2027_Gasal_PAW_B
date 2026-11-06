<?php
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");

$hasil = array();
foreach ($weight as $nama => $berat) {
    $hasil[] = '"' . $nama . '"=>"' . $berat . '"';
}
echo "weight = (" . implode(", ", $hasil) . ")<br>";

echo "Data kedua: " . $weight["Barry"];
?>