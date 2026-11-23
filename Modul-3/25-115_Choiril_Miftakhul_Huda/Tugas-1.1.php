<?php  
$fruits = array("Avocado","Blueberry","Cherry");
array_push($fruits, "Durian", "Eldberry", "Fig", "Grape", "Honeydew");

foreach ($fruits as $x) {
	echo "$x ";
}
echo "<br>";

echo end($fruits);
?>
