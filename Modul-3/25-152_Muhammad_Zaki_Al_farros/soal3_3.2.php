<?php
$weight = array('Andy' => '70', 'Barry' => '65', 'Charlie' => '75');

$jumlah = count($weight);
$no = 0;
echo 'weight = ( ';
foreach ($weight as $nama => $berat) {
    echo '"' . $nama . '"=>"' . $berat . '"';
    $no++;
    if ($no < $jumlah) {
        echo ', ';
    }
}
echo ' )<br>';

$nilai = array_values($weight);
echo 'Data kedua: ' . $nilai[1];
?>