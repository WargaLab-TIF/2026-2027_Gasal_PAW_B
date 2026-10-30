<?php
$height = array("Andy"=>"70","Barry"=>"65","Charlie"=>"75");
echo "weight=(";

foreach ($height as $nama=> $tinggi) {
 	echo '"' . $nama . '"=>"' . $tinggi . '"'; 
	if ($nama != "Charlie") { 
		echo ", "; } 
 } 
echo "<br>Data kedua: "; 
echo end($height); 
?>