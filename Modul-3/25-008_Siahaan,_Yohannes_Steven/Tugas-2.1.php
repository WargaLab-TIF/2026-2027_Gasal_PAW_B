<?php
$fruits = array("Avocado","Blueberry","Cherry");

for ($x=0; $x < 5; $x++) { 
	$fruits[] = "Buah tambahan " .$x+1;
}

$arrlength = count($fruits);
echo "Panjang array saat ini: " .$arrlength. "<br><br>";

for ($i=0; $i < $arrlength; $i++) { 
	echo $fruits[$i] . "<br>";
}

?>