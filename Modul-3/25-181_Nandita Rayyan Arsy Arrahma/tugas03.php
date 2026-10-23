<?php 
	$height = array("Andy" => "176", "Barry" => "162", "Charlie" => "170");
	echo "Andy is" . $height["Andy"] . " cm tall <br>";

	$height["Davied"] = 180;
	$height["Ethan"] = 172;
	$height["Frank"] = 168;
	$height["Georgeo"] = 175;
	$height["Harry"] = 182;

	echo "height = (";

	foreach ($height as $nama => $tinggi) {
		echo '"' . $nama . '"' . ' => ' . '"' . $tinggi . '" ,';
	}
	echo ") <br>";

	$idx_akhir = array_key_last($height);
	echo "Nilai dengan indeks terakhir: ".$height[$idx_akhir]."<br><br>";

	//izin menandai agar tidak bingung kak, ini setelah di hilangkan.

	unset($height["Barry"]);

	echo "height = (";

	foreach ($height as $nama => $tinggi) {
		echo '"' . $nama . '"' . ' => ' . '"' . $tinggi . '" ,';
	}
	echo ") <br>";

	$idx_akhir = array_key_last($height);
	echo "Nilai dengan indeks terakhir setelah dihapus : ".$height[$idx_akhir]."<br><br>";

	//ini untuk soal kedua di nomor 3

	$weight = array("Andy" => "70", "Barry" => "65", "Charlie" => "75");

	echo "height = (";

	foreach ($weight as $nama => $berat) {
		echo '"' . $nama . '"' . ' => ' . '"' . $berat . '" ,';
	}
	echo ") <br>";
	echo "Data Kedua: " . $weight["Barry"];
?>