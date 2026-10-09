<?php 
$fruits = array("Avocado","Blueberry","Cherry");
array_push($fruits, "durian", "elderberry", "Fig", "Grape", "Honeydew");

unset($fruits[1]);
echo "Data Blueberry dihapus.<br>";
echo 'fruits = ("'.implode('", "', $fruits).'")';
echo "<br>Nilai dengan indeks tertinggi: ".end($fruits);
?>