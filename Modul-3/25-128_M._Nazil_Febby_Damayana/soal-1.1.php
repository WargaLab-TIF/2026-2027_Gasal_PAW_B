<?php 
$fruits = array("Avocado","Blueberry","Cherry");
array_push($fruits, "durian", "elderberry", "Fig", "Grape", "Honeydew");

echo "fruits = ("'.implode('", "', $fruits).'")";
echo "<br>Nilai dengan indeks tertinggi: ".$fruits[count($fruits) - 1];
?>