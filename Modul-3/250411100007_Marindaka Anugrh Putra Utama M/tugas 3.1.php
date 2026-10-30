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
$nilai = array_values($height);

echo 'height = ' . tampil($height) . '<br>';
echo 'Nilai dengan indeks terakhir: ' . $nilai[count($nilai) - 1] . '<br><br>';

unset($height['Barry']);
$nilai = array_values($height);

echo 'height = ' . tampil($height) . '<br>';
echo 'Nilai dengan indeks terakhir setelah dihapus: ' . $nilai[count($nilai) - 1];