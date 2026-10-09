<?php
	$fruit = array("Avocado", "Blueberry","Cheryy");
	

	for ($i = 1; $i<6; $i++) {
        $fruit[] = "Buah Tambahan ".$i;
    };

    $arrlength = count($fruit);
    echo "Panjang array saat ini: ".$arrlength."<br>";

    foreach ($fruit as $value) {
    	echo $value."<br>";
    }

?>