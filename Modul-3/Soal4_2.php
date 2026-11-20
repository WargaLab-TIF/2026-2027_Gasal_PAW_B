<?php  
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");
$out = array();

foreach($weight as $key => $val) {
    $out[] = '"' . $key . '"=>"' . $val . '"';
}
echo 'weight = (' . implode(', ', $out) . ')<br><br>';

$keys = array_keys($weight);
$arrlength = count($keys);

for ($x = 0; $x < $arrlength; $x++) {
    $nama = $keys[$x];
    $berat = $weight[$nama];
    echo $nama . " is " . $berat . " kg.<br>";
}
?>