<?php
$fruits = array("Avocado", "Bluebery", "Cherry");
$bifore = count($fruits);
array_push($fruits, "Durian", "Elderberry", "Fig" , "Grape", "Honeydew");
$after = count($fruits);

echo "Panjang array saat ini: " . $after. "<br><br>";
for($y=0; $y<$after; $y++){
	if ($y >= $bifore) {
		echo "buah tambah ".$y-$bifore+1 . "<br>";
	}
	else {
		echo $fruits[$y]. "<br>";
	}
}


$vegies = array("Carrot", "Brocoli", "Spinach");
for ($a= 0;$a < count($vegies);$a++){
	echo "<br>" . $vegies[$a];
}
?>