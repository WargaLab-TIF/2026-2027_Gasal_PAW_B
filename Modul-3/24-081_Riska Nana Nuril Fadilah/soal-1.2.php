<?php
$fruits = array("Avocado", "Blueberry", "Cherry");

array_push($fruits, "Durian", "Elderberry", "Fig", "Grape", "Honeydew");

unset($fruits[1]);

echo "Data Blueberry dihapus.<br>";
echo "fruits = ( ";

foreach ($fruits as $buah) {
    echo "$buah,";
}

echo ")";
echo "<br>Nilai dengan indeks tertinggi: " . $fruits[7];
?>