<?php
$matkul = array("PTI","ALPRO","DPW","STRUKDAT","JARKOM","PAW","PSBF","RPL");

foreach($matkul as $matkul)
	switch ($matkul ){
		case "PTI":
			echo "saya suka $matkul <br>";
			break;
		case "ALPRO":
			echo "saya suka $matkul <br>";
			break;
		case "DPW":
			echo "saya suka $matkul <br>";
			break;
		case "STRUKDAT":
			echo "saya suka $matkul <br>";
			break;
		case "JARKOM":
			echo "saya suka $matkul <br>";
			break;
		case "PAW":
			echo "saya suka $matkul <br>";
			break;
		default:
			echo "saya tidak mengambil matkul " . $matkul . "<br>";
			break;
	}
?>