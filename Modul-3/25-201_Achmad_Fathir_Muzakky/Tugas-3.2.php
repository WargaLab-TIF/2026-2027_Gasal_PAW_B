<?php
$weight = array("Andy" => "70","Barry" => "65","Charlie" => "75");
$y = array_keys($weight);

echo 'weight = ';

foreach ($weight as $key => $value) {
    echo "$key => $value ";
}

echo "<br>Data kedua: " . $weight[$y[1]];
?>