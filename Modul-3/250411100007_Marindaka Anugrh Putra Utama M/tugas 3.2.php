<?php
function tampil($arr) {
    $teks = array();
    foreach ($arr as $kunci => $nilai) {
        $teks[] = '"' . $kunci . '"=>"' . $nilai . '"';
    }
    return '(' . implode(', ', $teks) . ')';
}

$weight = array('Andy' => '70', 'Barry' => '65', 'Charlie' => '75');
$nilai = array_values($weight);

echo 'weight = ' . tampil($weight) . '<br>';
echo 'Data kedua: ' . $nilai[1];