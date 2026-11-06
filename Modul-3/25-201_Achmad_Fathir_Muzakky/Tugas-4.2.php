<?php
$weight = array("Andy" => "70","Barry" => "65","Charlie" => "75");

$y = array_keys($weight);
$arrlength = count($weight);

echo 'weight = ';

foreach ($weight as $key => $value) {
    echo "$key => $value ";
}

echo '<br><br>';

for ($i = 0; $i < $arrlength; $i++) {
    echo $y[$i] . " is " . $weight[$y[$i]] . " kg.<br>";
}
?>