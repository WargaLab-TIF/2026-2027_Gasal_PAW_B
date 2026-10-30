
<?php
$fruits = array("Avocado", "Blueberry", "Cherry");

array_push($fruits, "Durian", "Elderberry", "Fig", "Grape", "Honeydew");

unset($fruits[1]);

echo "Data Blueberry dihapus.<br>";

echo 'fruits = ( "';
echo implode('", "', array_values($fruits));
echo '" )';

echo "<br>";

echo "Nilai dengan indeks tertinggi: " . end($fruits);
?>
