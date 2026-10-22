<?php
$fruits = array("Avocado","Blueberry","Cherry");
array_push($fruits, "Durian", "Elderberry", "Fig", "Grape", "Honeydew");

$last = count($fruits) - 1;
$hapus = $fruits[1];

unset($fruits[1]);
print_r($fruits);

echo "<br>";
echo "Data ".$hapus." dihapus<br>";
echo "Nilai dengan indeks tertinggi: " .$fruits[$last];
?>