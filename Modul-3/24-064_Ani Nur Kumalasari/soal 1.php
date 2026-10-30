<?php
$fruits=array("Avocado"," Blueberry"," Cherry");
$fruits[]= " Durian";
$fruits[]= " Elderberry";
$fruits[]= " Fig";
$fruits[]= " Grape";
$fruits[]= " Honeydew";

echo "fruits = (";

foreach ($fruits as $buah) {
    echo $buah;
    if ($buah != " Honeydew") {
        echo ", ";
    }
}

echo ")<br>";
echo "nilai dengan indeks tertinggi = ";
echo $fruits[7];
?>