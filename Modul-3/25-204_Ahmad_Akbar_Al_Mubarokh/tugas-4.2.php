<?php 
$weight= array("Andy"=>"70","Barry"=>"65","Charlie"=>"75");
echo "Data kedua: ". $weight["Barry"];
foreach ($weight as $x => $y) {
	echo "$x is $y Kg.<br>";
};
?>