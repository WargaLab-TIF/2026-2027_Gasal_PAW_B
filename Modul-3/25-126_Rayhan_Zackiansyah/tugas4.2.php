<?php
// 4.2
echo "Soal 4.2<br>";

$weight = array(
    "Andy" => "70",
    "Barry" => "65",
    "Charlie" => "75"
);

echo "weight = (";
$jumlah = count($weight);
$nomor = 0;

foreach ($weight as $nama => $berat) {
    echo '"' . $nama . '"=>"' . $berat . '"';

    $nomor++;
    if ($nomor < $jumlah) {
        echo ", ";
    }
}
echo ")<br><br>";

$namaWeight = array_keys($weight);
$nilaiWeight = array_values($weight);

for ($i = 0; $i < count($weight); $i++) {
    echo $namaWeight[$i] . " is " . $nilaiWeight[$i] . " kg.<br>";
}
?>