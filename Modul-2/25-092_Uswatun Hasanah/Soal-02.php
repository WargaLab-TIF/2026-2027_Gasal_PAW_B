<?php
$matkul = ["PTI", "ALPRO","DPW", "STRUKDAT", "JARKOM", "PAW", "PSBF", "RPL"];
foreach($matkul as $value){
switch ($value){
	case "PTI":
		echo "saya suka PTI". "<br>";
		break;
	case "ALPRO":
		echo "saya suka ALPRO". "<br>";
		break;
	case "DPW":
		echo "saya suka DPW ". "<br>";
		break;
	case "STRUKDAT":
		echo "Saya suka STRUKDAT". "<br>";
		break;
	case "JARKOM":
		echo "saya suka JARKOM". "<br>";
		break;
	case "PAW":
		echo "saya suka PAW". "<br>";
		break;
	default:
		echo "tidak mengambil matkul". $value. "<br>";
		break;

}
}
?> 