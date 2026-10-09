<?php  
$fruits = array("Avocado","Blueberry","Cherry");

array_push($fruits, "Durian","Eldeberry","Fig","Grape","Honeydew");
echo "fruits = (";
foreach ($fruits as $value) {
	echo "$value, ";
}
echo")<br>";
echo "Nilai dengan Indeks tertinggi : ".end($fruits);
?>
