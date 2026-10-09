<?php
	$fruits = array("Avocado","Blueberry","Cherry");
	$arrlength = count($fruits);
	for($x = 0; $x < 8; $x++) {
		array_push($fruits, "Buah Tambahan".$x);
		echo $fruits[$x];
		echo "<br>";
	};
	echo "Jumlah Array". $x."<br>";
?>