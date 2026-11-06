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

echo "weight = "; tampil($weight); echo "<br><br>";

$keys   = array_keys($weight);
$jumlah = count($keys);

for ($i = 0; $i < $jumlah; $i++) {
    $nama = $keys[$i];
    echo $nama . " is " . $weight[$nama] . " kg.";
    echo "<br>";
}
?>
