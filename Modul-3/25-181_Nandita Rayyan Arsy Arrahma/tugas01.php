<?php 
	$fruits = array("Avocado", "Blueberry", "Cherry");

	$fruits [] = 'Durian';
	$fruits [] = 'Elderberry';
	$fruits [] = 'Fig';
	$fruits [] = 'Grape';
	$fruits [] = 'Honeydew';

	echo "fruits = (";

	foreach ($fruits as $buah) {
		echo '"' . $buah . '" ,';
	}
	echo ") <br>";

	$max_indeks = count($fruits)-1;
	echo "Nilai dengan indeks tertinggi " . $fruits[$max_indeks];
	echo "<br>";
	echo "<br>";

	//izin menandai kak: ini untuk soal 1.2

	unset($fruits[1]);
	echo "Data Blueberry dihapus: <br>";
	echo "fruits = (";

	foreach ($fruits as $buah) {
		echo '"' . $buah . '" ,';
	}
	echo ") <br>";
	$max_indeks = count($fruits);
	echo "Nilai dengan indeks tertinggi " . $fruits[$max_indeks];
?>