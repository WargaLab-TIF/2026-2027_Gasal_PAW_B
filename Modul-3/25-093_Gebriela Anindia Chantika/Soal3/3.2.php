<?php
$weight = array("Andy" => "70", "Barry" => "65", "Charlie" => "75");
echo "weight = ";
print_r($weight);
echo "<br>";
$keys = array_keys($weight);
$second_key = $keys[1]; // Indeks ke-1 merujuk ke data kedua

echo "Data kedua: " . $weight[$second_key];
?>