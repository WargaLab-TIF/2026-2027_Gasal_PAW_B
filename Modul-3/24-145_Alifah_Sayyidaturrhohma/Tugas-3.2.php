<?php  
$weight = array("Andy"=>"70","Barry"=>"65","Charlie"=>"75");
echo "weight = (";
foreach ($weight as $key => $value){
	echo $key."=>".$value." ";
} 
echo ")<br>";
echo "Data kedua :".$weight["Barry"];
?>
