<?php
	$height = array(
        "Andy" => "176",
        "Barry" => "165",
        "Charlie" => "170"
    );

    $height["David"] = "180";
    $height["Ethan"] = "172";
    $height["Frank"] = "168";
    $height["George"] = "175";
    $height["Harry"] = "182";

    $i = 0;
    $total = count($height);

    echo 'height = ( ';
    foreach ($height as $name => $tinggi) {
        echo '"' . $name . '" => "' . $tinggi . '"';

        if ($i < $total - 1) {
            echo ', ';
        }

        $i++;

        $lastvalue = $tinggi;
    }
    echo ' )<br><br>';

    foreach($height as $key => $value){
    	echo $key. ' is '. $value. ' cm tall.<br>';
    }
?>