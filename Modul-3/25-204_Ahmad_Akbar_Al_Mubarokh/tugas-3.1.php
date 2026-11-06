<?php
$height = array("Andy"=>"176","Barry"=>"165","Charlie"=>"170");
	$height["David"]="180";
	$height["Ethan"]="172";
	$height["Frank"]="168";
	$height["George"]="175";
	$height["Harry"]="182";
	unset($height["Andy"]);
echo "Nilai dengan indeks terakhir setelah dihapus: ".end($height)."<br>";

?>