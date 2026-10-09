<?php
$weight = array("Andy"=>"70","Barry"=>"65","Charlie"=>"75");

// foreach ($weight as $key => $value) {
// 	echo $key . " is " . $value . " kg<br>";
// }
$keys = array_keys($weight);
$values = array_values($weight);

for ($i = 0; $i < count($weight); $i++) { 
    $key = $keys[$i];
    $value = $values[$i];
    echo $key . " is " . $value . " kg<br>";
}
// for ($i=0; $i <= count($weight) ; $i++) { 
// 	$key = $weight[$i][0];
// 	$value = $weight[$i][1];
// 	echo $key . " is " . $value . " kg<br>";
	
// }

?>