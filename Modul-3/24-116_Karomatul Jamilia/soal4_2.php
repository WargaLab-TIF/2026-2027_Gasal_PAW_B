<?php
	$weight = array('Andi' => '70', 'Barry' => '65', 'Charlie' => '75');

	$i = 0;
	echo "weight = (";
	foreach($weight as $key => $value){
		echo '"'.$key.'" => "'.$value. '"';

		if ($i < count($weight)-1){
			echo ', ';
		};
		$i+=1;
	}

	echo ')<br><br>';

	foreach($weight as $name => $weightValue){
		echo $name. ' is '.$weightValue. ' kg.<br>';
	}
?>