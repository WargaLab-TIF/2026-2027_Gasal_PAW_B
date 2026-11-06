<?php
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");

$height["David"]  = "180";
$height["Ethan"]  = "172";
$height["Frank"]  = "168";
$height["George"] = "175";
$height["Harry"]  = "182";

$hasil = array();
foreach ($height as $nama => $tinggi) {
    $hasil[] = '"' . $nama . '"=>"' . $tinggi . '"';
}
echo "height = (" . implode(", ", $hasil) . ")<br>";

echo "Nilai dengan indeks terakhir: " . $height[array_key_last($height)] . "<br><br>";

unset($height["Barry"]);

$hasil = array();
foreach ($height as $nama => $tinggi) {
    $hasil[] = '"' . $nama . '"=>"' . $tinggi . '"';
}
echo "height = (" . implode(", ", $hasil) . ")<br>";

echo "Nilai dengan indeks terakhir setelah dihapus: " . $height[array_key_last($height)] . "<br><br>";

?>