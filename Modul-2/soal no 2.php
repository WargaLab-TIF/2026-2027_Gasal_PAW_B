<?php

$matkul=["PTI","ALPRO","DPW","STRUKDAT","JARKOM","PAW","PSBF","RPL"];
foreach ($matkul as $pl){
	switch ($pl) {
		case 'PTI':
			echo "saya suka " .$pl. "<br>";
			break;
		case 'ALPRO':
			echo "saya suka ".$pl. "<br>";
			break;
		case 'DPW':
			echo "saya suka " .$pl. "<br>";
			break;
		case 'STRUKDAT':
			echo "saya suka ".$pl. "<br>";
			break;
		case 'JARKOM':
			echo "saya suka ".$pl. "<br>";
			break;
		case 'PAW':
			echo "saya suka ".$pl. "<br>";
			break;
		default:
			echo'saya tidak mengambil matkul '.$pl. "<br>";
	}
}
?>