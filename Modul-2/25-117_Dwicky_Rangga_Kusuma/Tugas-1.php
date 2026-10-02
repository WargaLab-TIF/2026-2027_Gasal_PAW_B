<?php 
$matkul = ["PTI","ALPRO","DPW","STRUKDAT","JARKOM","PAW","PSBF","RPL"];
$praktikum = ["JARKOM","PAW"];

for($x=0;$x<count($matkul);$x++) {
	if ($matkul[$x] == $praktikum[0] || $matkul[$x] == $praktikum[1]) {
		echo "Saya sedang mengambil matkul $matkul[$x] termasuk praktikumnya<br>";
	}
	elseif ($x == 6 || $x == 7) {
		echo "Saya belum mengambil matkul $matkul[$x]<br>";
	}
	else {
		echo "Saya sudah mengambil matkul $matkul[$x] semester lalu<br>";
	}
}
 ?>