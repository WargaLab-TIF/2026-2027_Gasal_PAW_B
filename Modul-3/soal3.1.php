<?php
$weight = array(
    "Andy" => 65,
    "Barry" => 70,
    "Charlie" => 58
);

$keys = array_keys($weight);
$kunciKedua = $keys[1];

echo $kunciKedua . " = " . $weight[$kunciKedua] . " kg";
?>