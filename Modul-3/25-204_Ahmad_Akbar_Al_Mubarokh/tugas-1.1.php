<?php  
$fruits=array("Avocado","Blueberry","Cherry");
array_push($fruits, "Durian","Elderberry","Fig","Grape","Honeydew");
echo "fruits = (".implode(",",$fruits).")<br>";
echo "Nilai dengan indeks tertinggi:".end($fruits)."<br>";
?>