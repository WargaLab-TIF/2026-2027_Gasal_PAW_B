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
echo ' )<br><br>';

$kunci = array_keys($weight);
for ($i = 0; $i < $jumlah; $i++) {
    $nama = $kunci[$i];
    echo $nama . ' is ' . $weight[$nama] . ' kg.<br>';
}
?>
