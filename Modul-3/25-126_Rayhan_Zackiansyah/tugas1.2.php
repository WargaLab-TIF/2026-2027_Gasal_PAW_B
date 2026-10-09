<?php

// 1.2
echo "Soal 1.2<br>";

$fruits = array("Avocado", "Blueberry", "Cherry");

$fruits[] = "Durian";
$fruits[] = "Elderberry";
$fruits[] = "Grape";
$fruits[] = "Fig";
$fruits[] = "Honeydew";

echo "Data $fruits[1] Dihapus<br>";

unset($fruits[1]);

echo "Fruits: (";
foreach ($fruits as $x) {
  echo "$x, ";
}
echo ")";

$idx = max(array_keys($fruits));

echo "<br>Nilai indeks tertinggi: " . $fruits[$idx];

?>