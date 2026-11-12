<?php
	$fruit = array("Avocado", "Blueberry","Cheryy");
	$fruit[] = "Durian";
	$fruit[] = "Eldeberry";
	$fruit[] = "Fig";
	$fruit[] = "Grape";
	$fruit[] = "Honeydew";

	

	echo "Data ".$fruit[1]." dihapus<br>";
	unset($fruit[1]);
	
	echo "fruits = ( ";
	foreach ($fruit as $value) {
		echo'"' .$value. '", ';
		
	}
	
	echo ")<br>";
	echo "Nilai dengan indeks tertinggi: ". $fruit[count($fruit)];

?>