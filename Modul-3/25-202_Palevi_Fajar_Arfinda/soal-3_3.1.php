<?php

$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");

function tampil($arr) {
    $hasil = array();
    foreach ($arr as $k => $v) { $hasil[] = '"' . $k . '"=>"' . $v . '"'; }
    return '(' . implode(', ', $hasil) . ')';
}

$height["David"]  = "180";
$height["Ethan"]  = "172";
$height["Frank"]  = "168";
$height["George"] = "175";
$height["Harry"]  = "182";

echo "height = " . tampil($height) . "<br>";
echo "Nilai dengan indeks terakhir: " . $height[array_key_last($height)] . "<br><br>";

unset($height["Barry"]);

echo "height = " . tampil($height) . "<br>";
echo "Nilai dengan indeks terakhir setelah dihapus: " . $height[array_key_last($height)];
?>