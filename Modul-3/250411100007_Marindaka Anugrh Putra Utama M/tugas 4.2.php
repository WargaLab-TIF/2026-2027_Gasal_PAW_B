<?php
function tampil($arr) {
    $teks = array();
    foreach ($arr as $kunci => $nilai) {
        $teks[] = '"' . $kunci . '"=>"' . $nilai . '"';
    }
    return '(' . implode(', ', $teks) . ')';
}

$weight = array('Andy' => '70', 'Barry' => '65', 'Charlie' => '75');
$nama = array_keys($weight);

echo 'weight = ' . tampil($weight) . '<br><br>';
for ($x = 0; $x < count($nama); $x++) {
    echo $nama[$x] . ' is ' . $weight[$nama[$x]] . ' kg.<br>';
}