<?php  
$fruits = array("Avocado","Blueberry","Cherry");
echo "Data $fruits[1] dihapus <br>";
unset($fruits[1]); 

array_push($fruits, "Durian","Eldeberry","Fig","Grape","Honeydew");
echo "fruits = (";;
foreach ($fruits as $value) {
	echo " $value , ";
}
echo")<br>";
echo "Nilai dengan Indeks tertinggi : ".end($fruits);
?>
