<?php
$height = array(
    "Andy" => "176",
    "Barry" => "165",
    "Charlie" => "170"
);

$height["Diana"] = "168";
$height["Ethan"] = "180";
$height["Farah"] = "162";
$height["Gavin"] = "175";
$height["Helen"] = "169";

foreach ($height as $nama => $tinggi) {
    echo $nama . " memiliki tinggi " . $tinggi . " cm.<br>";
}
?>