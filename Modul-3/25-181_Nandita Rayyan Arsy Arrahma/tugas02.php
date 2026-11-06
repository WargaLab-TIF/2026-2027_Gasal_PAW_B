<?php 
	$fruits = array("Avocado", "Blueberry", "Cherry");

	$fruits[] = 'Markisa';
	$fruits[] = 'Elderberry';
	$fruits[] = 'Kesemek';
	$fruits[] = 'Grape';
	$fruits[] = 'Kelengkeng';

	$arrlength = count($fruits);
	echo "Panjang array saat ini: " . $arrlength . "<br><br>";

	for($x = 0; $x < $arrlength; $x++) {
		echo $fruits[$x];
		echo "<br>";
	}

	echo "<br>";

	//izin menandai kak: ini untuk soal yang 2.2

	$vegies = array("Carrot", "Broccoli", "Spinach");
	$arrlength = count($vegies);
	echo "Panjang array saat ini: " . $arrlength . "<br><br>";

	for($x = 0; $x < $arrlength; $x++) {
		echo $vegies[$x];
		echo "<br>";
	}
?>