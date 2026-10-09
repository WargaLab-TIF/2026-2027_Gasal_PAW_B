<?php
$weight = array(
    "Andy" => 65,
    "Barry" => 70,
    "Charlie" => 58
);

$keys = array_keys($weight);

for ($i = 0; $i < count($keys); $i++) {
    $nama = $keys[$i];
    echo $nama . " memiliki berat " . $weight[$nama] . " kg.<br>";
}
?>