<?php
$fruits = array("Avocado", "Blueberry", "Cherry");

$hapus = $fruits[1];
unset($fruits[1]);

echo "Data " . $hapus . " dihapus<br>";

$indeksTerakhir = array_key_last($fruits);
echo "Nilai indeks tertinggi: " . $fruits[$indeksTerakhir];
?>

