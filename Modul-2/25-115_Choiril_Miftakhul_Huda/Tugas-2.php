<?php  
	$matkul = array("PTI", "ALPRO", "DPW", "STRUKDAT", "JARKOM", "PAW", "PSBF", "RPL");

	foreach ($matkul as $key => $value) {
		switch ($value) {
			case "PTI":
				echo "Saya suka " . $value . "<br>";
				break;
			case "ALPRO":
				echo "Saya suka " . $value . "<br>";
				break;
			case "DPW":
				echo "Saya suka " . $value . "<br>";
				break;
			case "STRUKDAT":
				echo "Saya suka " . $value . "<br>";
				break;
			case "JARKOM":
				echo "Saya suka " . $value . "<br>";
				break;
			case "PAW":
				echo "Saya suka " . $value . "<br>";
				break;

			default:
				echo "Saya tidak mengambil matkul " . $value . "<br>";
				break;
		}
	}
?>