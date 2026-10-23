<?php
$fruits = array("Avocado", "Blueberry", "Cherry");
array_push($fruits, "Durian", "Elderberry", "Fig", "Grape", "Honeydew");
$hapus = $fruits[1];
unset($fruits[1]);
echo "Data $hapus dihapus<br>";
echo "fruits = (";
foreach($fruits as $fruit){
    echo "$fruit, ";
}
echo ")<br>";
$tinggi = $fruits[count($fruits)-1];
echo "Nilai dengan indeks tertinggi: $tinggi";
 ?>