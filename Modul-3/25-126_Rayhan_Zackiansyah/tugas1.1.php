<?php

//1.1

echo "Soal 1.1<br>";
$fruits = array("Avocado", "Blueberry", "Cherry");

$fruits[] = "Durian";
$fruits[] = "Elderberry";
$fruits[] = "Grape";
$fruits[] = "Fig";
$fruits[] = "Honeydew";

echo "Fruits: (";
foreach ($fruits as $x) {
  echo "$x, ";
}
echo ")";
$idx = count($fruits) - 1;

echo "<br>Nilai indeks tertinggi: " . $fruits[$idx];
?>