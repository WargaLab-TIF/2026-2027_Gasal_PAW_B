<?php 
	$matkul = array("PTI", "ALPRO", "DPW", "STRUKDAT", "JARKOM", "PAW", "PSBF", "RPL");
	$praktikum = array("JARKOM", "PAW");

	for ($i = 0; $i < count($matkul); $i++) {
		$value = $matkul[$i];

		if (in_array($value, $praktikum)) {
			echo "Saya sedang mengambil matkul ". $value." termasuk praktikum nya<br>";
		} elseif ($i == 6 || $i == 7) {
			echo "Saya belum mengambil matkul ". $value."<br>";
		} else {
			echo "Saya sudah mengambil matkul ". $value." semester lalu<br>";
		};
	};
?>