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

$kunciTerakhir = array_key_last($height);
echo "Sebelum dihapus: " . $height[$kunciTerakhir] . " cm<br>";

unset($height["Ethan"]);

$kunciTerakhir = array_key_last($height);
echo "Setelah dihapus: " . $height[$kunciTerakhir] . " cm";
?>