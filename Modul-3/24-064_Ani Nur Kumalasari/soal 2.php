<?php
$fruits=array("Avocado","Blueberry","Cherry");
$buahBaru=array("Buah tambahan 1","Buah tambahan 2","Buah tambahan 3","Buah tambahan 4","Buah tambahan 5");

for ($i = 0; $i < count($buahBaru); $i++){
	$fruits[]=$buahBaru[$i];
}
$arrlength=count($fruits);

echo"panjang array saat ini:";
echo count($fruits);
echo "<br>";

for($x = 0;$x <$arrlength;$x++){
	echo "$fruits[$x]";
	echo "<br>";
}