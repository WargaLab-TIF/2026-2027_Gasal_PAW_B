<?php
function tampil($arr) {
    $teks = array();
    foreach ($arr as $kunci => $nilai) {
        $teks[] = '"' . $kunci . '"=>"' . $nilai . '"';
    }
    return '(' . implode(', ', $teks) . ')';
}

$height = array('Andy' => '176', 'Barry' => '165', 'Charlie' => '170');
$height += array('David' => '180', 'Ethan' => '172', 'Frank' => '168', 'George' => '175', 'Harry' => '182');

echo 'height = ' . tampil($height) . '<br><br>';
foreach ($height as $nama => $nilai) {
    echo $nama . ' is ' . $nilai . ' cm tall.<br>';
}