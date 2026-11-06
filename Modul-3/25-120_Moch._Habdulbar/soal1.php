<?php

$fruits = array("Avocado","Blueberry","Cherry");

//1.1
$fruits[] = "Durian";
$fruits[] = "Elderberry";
$fruits[] = "Fig";
$fruits[] = "Grape";
$fruits[] = "Honeydew";

echo "fruits= (";
foreach ($fruits as $buah) {
  echo $buah . ", ";
}
echo ")";
echo "<br> Nilai dengan indeks tertinggi= ". max($fruits);


//1.2
unset($fruits[1]);

echo "<br><br>Data Blueberry dihapus<br>";
echo "fruit= ";
foreach ($fruits as $buah) {
  echo $buah . ", ";
}
echo "<br> Nilai dengan indeks tertinggi= ". max($fruits);

?>