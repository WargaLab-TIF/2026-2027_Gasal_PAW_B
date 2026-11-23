<?php
// 4.1
echo "Soal 4.1<br>";

$height = array(
    "Andy" => "176",
    "Barry" => "165",
    "Charlie" => "170"
);

$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

echo "height = (";
$jumlah = count($height);
$nomor = 0;

foreach ($height as $nama => $tinggi) {
    echo '"' . $nama . '"=>"' . $tinggi . '"';

    $nomor++;
    if ($nomor < $jumlah) {
        echo ", ";
    }
}
echo ")<br><br>";

// Menampilkan nama dan tinggi badan menggunakan foreach
foreach ($height as $nama => $tinggi) {
    echo $nama . " is " . $tinggi . " cm tall.<br>";
}

echo "<br><br>";
?>