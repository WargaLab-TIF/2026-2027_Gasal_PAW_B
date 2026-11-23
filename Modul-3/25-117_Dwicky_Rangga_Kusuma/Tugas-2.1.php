<?php
$fruits = array("Avocado", "Blueberry", "Cherry");
for($i = 1; $i <= 5; $i++){
    array_push($fruits, "buah tambahan ".$i);
}
$arrlength = count($fruits);
echo "Panjang array saat ini: $arrlength <br><br>";
for($x = 0; $x < $arrlength; $x++){
    echo "$fruits[$x]<br>";
}
 ?>