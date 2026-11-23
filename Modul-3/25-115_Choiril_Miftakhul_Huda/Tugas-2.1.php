<?php  
$fruits = array("Avocado","Blueberry","Cherry");
$arrlength = count($fruits);
for ($i=0; $i < 5; $i++) { 
	$fruits[] = "Buah Tambahan " . $i+1;
}
$arrlength = count($fruits);

echo "Panjang array saat ini: " . $arrlength . "<br><br>";
foreach ($fruits as $x) {
	echo "$x ";
	echo "<br>";
}
?>

