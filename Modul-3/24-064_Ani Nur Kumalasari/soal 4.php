<?php
$height = array("Andy"=>"176","Barry"=>"165","Charlie"=>"170");

$height["david"] = "180";
$height["ethan"] = "172";
$height["frank"] = "168";
$height["george"] = "175";
$height["harry"] = "182";

echo "height = (";

foreach ($height as $nama => $tinggi) {
    echo '"' . $nama . '" => "' . $tinggi . '"';

    if ($nama != "harry") {
        echo ", ";
    }
}

echo ")<br><br>";

foreach ($height as $nama => $tinggi) {
    echo $nama . " is " . $tinggi . " cm tall";
    echo "<br>";
}
?>