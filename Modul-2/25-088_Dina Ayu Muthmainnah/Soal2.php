<?php 
$matkul=["PTI","ALPRO","DPW","STRUKDAT","JARKOM","PAW","PSBF","RPL"];
foreach ($matkul as $key => $value) {
	switch ($value) {
		case 'PTI':
			echo "SayasukaPTI<br>";
			break;
		case 'ALPRO':
			echo "SayasukaALPRO<br>";		
			break;
		case 'DPW':
			echo "sayasukaDPW<br>";
			break;
		case 'STRUKDAT':
			echo "SayasukaSTRUKDAT<br>";
			break;
		case 'JARKOM':
			echo "SayasukaJARKOM<br>";
			break;
		case 'PAW':
			echo "SayasukaPAW<br>";
			break;
		default:
			echo "Saya tidak mengambil matkul".$value."<br>";
			break;
	}
 } ?>