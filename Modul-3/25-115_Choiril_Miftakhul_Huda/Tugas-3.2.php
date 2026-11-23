<?php
$weight = array("Andy"=>"70","Barry"=>"65","Charlie"=>"75");
foreach ($weight as $key => $value) {
	echo $key . " = " . $value . "<br>";
}
$values = array_values($weight);
echo "Data kedua: " . $values[1];
?>
