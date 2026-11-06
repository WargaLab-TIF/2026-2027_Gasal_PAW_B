<?php  
$fruits=array("Avocado","Blueberry","Cherry");
array_push($fruits, "Durian","Elderberry","Fig","Grape","Honeydew");
echo "data $fruits[1] dihapus.<br>";
unset($fruits[1]);
echo "fruits =(".implode(",",$fruits).")<br>";
echo "Nilai dengan indeks tertinggi:".end($fruits)."<br>";
?>