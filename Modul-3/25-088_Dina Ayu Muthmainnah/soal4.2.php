<?php
$weight = array(
    "Andy" => "70",
    "Barry" => "65",
    "Charlie" => "75"
);
echo "weight=";
print_r($weight); 
echo "<br>";
$nama = array_keys($weight);
$arrlength = count($weight);
for ($i = 0; $i < $arrlength; $i++) {
    echo $nama[$i] . " is " . $weight[$nama[$i]] . " kg.<br>";
}
?>