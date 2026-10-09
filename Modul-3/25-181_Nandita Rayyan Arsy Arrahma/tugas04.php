<?php 
	$height = array("Andy" => "176", "Barry" => "165", "Charlie" => "170");

	$height["Davied"] = 180;
	$height["Ethan"] = 172;
	$height["Frank"] = 168;
	$height["Georgeo"] = 175;
	$height["Harry"] = 182;

	echo "height = (";

	foreach ($height as $nama => $tinggi) {
		echo '"' . $nama . '"' . ' => ' . '"' . $tinggi . '" ,';
	}
	echo ") <br><br>";

	$key = array_keys($height);
	$arrlength = count($height);

	for($x = 0; $x < $arrlength; $x++) {
		$nama = $key[$x];
		$tinggi = $height[$nama];

		echo $nama . " is " . $tinggi . " cm tall.";
		echo "<br>";
	}
	echo "<br><br>";

	//ini untuk jawaban no 4.2

	$weight = array("Andy" => "70", "Barry" => "65", "Charlie" => "75");

	echo "weight = (";

	foreach ($weight as $nama => $tinggi) {
		echo '"' . $nama . '"' . ' => ' . '"' . $tinggi . '" ,';
	}
	echo ") <br>";

	$key = array_keys($weight);
	$arrlength = count($weight);

	for($x = 0; $x < $arrlength; $x++) {
		$nama = $key[$x];
		$tinggi = $weight[$nama];

		echo $nama . " is " . $tinggi . " kg.";
		echo "<br>";
	}
?>