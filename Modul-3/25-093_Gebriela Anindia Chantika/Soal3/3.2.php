<?php
$weight = array("Andy" => "70", "Barry" => "65", "Charlie" => "75");
echo 'weight = (';
$i = 0;
foreach ($weight as $k => $v) {
    echo '"' . $k . '"=>"' . $v . '"';
    if ($i < count($weight) - 1) {
        echo ', ';
    }
    $i++;
}
echo ')<br>';

$keys = array_keys($weight);
$second_key = $keys[1];

echo "Data kedua: " . $weight[$second_key];
?>