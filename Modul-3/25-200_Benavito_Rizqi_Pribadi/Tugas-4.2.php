<?php
$weight = array(
    "Andy" => "70",
    "Barry" => "65",
    "Charlie" => "75"
);

$nama = array_keys($weight);
$arrlength = count($weight);

echo 'weight = (';
for ($i = 0; $i < $arrlength; $i++) {
    echo '"' . $nama[$i] . '"' . "=>" . '"' . $weight[$nama[$i]] . '"' .",";
}
echo ')';

echo "<br><br>";

for ($i = 0; $i < $arrlength; $i++) {
    echo $nama[$i] . " is " . $weight[$nama[$i]] . " kg.<br>";
}

?>