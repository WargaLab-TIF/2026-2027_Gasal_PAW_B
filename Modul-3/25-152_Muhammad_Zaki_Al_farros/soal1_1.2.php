<?php
$fruits = array('Avocado', 'Blueberry', 'Cherry');
array_push($fruits, "Durian", "Elderberry", "Fig", "Grape", "Honeydew");

echo "Data ".$fruits[1]." dihapus.";
unset($fruits[1]);
$fruits = array_values($fruits);

$jumlah = count($fruits);
echo 'fruits = ( ';
for ($i = 0; $i < $jumlah; $i++) {
    echo '"' . $fruits[$i] . '"';
    if ($i < $jumlah - 1) {
        echo ', ';
    }
}
echo ' )<br>';
echo "Nilai dengan indeks tertinggi: " . $fruits[count($fruits)-1];
?>