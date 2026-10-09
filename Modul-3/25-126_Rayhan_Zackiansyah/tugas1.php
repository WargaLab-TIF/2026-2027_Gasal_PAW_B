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

echo "<br><br>";
//1.2

echo "<br>Soal 1.2";

echo "<br>Data $fruits[1] Dihapus<br>";

unset($fruits[1]);

echo "Fruits: (";
foreach ($fruits as $x) {
  echo "$x, ";
}
echo ")";

$idx = max(array_keys($fruits));
echo "<br>Nilai indeks tertinggi: " . $fruits[$idx];

?>