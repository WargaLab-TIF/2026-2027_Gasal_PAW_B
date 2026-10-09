<?php

$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");

function tampil($arr) {
    $jumlah = count($arr);
    $no = 0;
    echo '(';
    foreach ($arr as $k => $v) {
        echo '"' . $k . '"=>"' . $v . '"';
        $no++;
        if ($no < $jumlah) { echo ', '; }
    }
    echo ')';
}

echo "weight = "; tampil($weight); echo "<br>";
$values = array_values($weight);
echo "Data kedua: " . $values[1];
?>