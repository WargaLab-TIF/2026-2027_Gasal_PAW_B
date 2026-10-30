<?php
$height = array("Andy"=>"70","Barry"=>"65","Charlie"=>"75");

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