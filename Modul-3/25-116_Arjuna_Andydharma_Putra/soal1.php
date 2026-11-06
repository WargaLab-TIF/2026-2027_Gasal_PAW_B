<?php
// 1.1 Menambahkan lima data baru
$fruits = array("Avocado", "Blueberry", "Cherry");

$fruits[] = "Durian";
$fruits[] = "Elderberry";
$fruits[] = "Fig";
$fruits[] = "Grape";
$fruits[] = "Honeydew";

echo "fruits = (";
for ($i = 0; $i < count($fruits); $i++) {
    echo '"' . $fruits[$i] . '"';
    if ($i < count($fruits) - 1) {
        echo ", ";
    }
}
echo ")<br>";

$indeks_tertinggi = array_key_last($fruits);
echo "Nilai dengan indeks tertinggi: " . $fruits[$indeks_tertinggi] . "<br><br>";

// 1.2 Hapus satu data tertentu (Blueberry = indeks 1)
unset($fruits[1]);

echo "Data Blueberry dihapus.<br>";

echo "fruits = (";
$keys = array_keys($fruits);
for ($i = 0; $i < count($keys); $i++) {
    echo '"' . $fruits[$keys[$i]] . '"';
    if ($i < count($keys) - 1) {
        echo ", ";
    }
}
echo ")<br>";

$indeks_tertinggi = array_key_last($fruits);
echo "Nilai dengan indeks tertinggi: " . $fruits[$indeks_tertinggi];
?>