<?php
// 3.1 Tambahkan lima data baru ke array $height
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");

// Menambah elemen (cara modul)
$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

echo "height = (";
$i = 0;
foreach ($height as $k => $v) {
    echo '"' . $k . '"=>"' . $v . '"';
    if ($i < count($height) - 1) {
        echo ", ";
    }
    $i++;
}
echo ")<br>";

$last_key = array_key_last($height);
echo "Nilai dengan indeks terakhir: " . $height[$last_key] . "<br><br>";

unset($height["Barry"]);

echo "height = (";
$i = 0;
foreach ($height as $k => $v) {
    echo '"' . $k . '"=>"' . $v . '"';
    if ($i < count($height) - 1) {
        echo ", ";
    }
    $i++;
}
echo ")<br>";

// Nilai dengan indeks terakhir setelah dihapus
$last_key = array_key_last($height);
echo "Nilai dengan indeks terakhir setelah dihapus: " . $height[$last_key] . "<br><br>";

// 3.2 Buat array baru $weight dan tampilkan data kedua
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");

echo "weight = (";
$i = 0;
foreach ($weight as $k => $v) {
    echo '"' . $k . '"=>"' . $v . '"';
    if ($i < count($weight) - 1) {
        echo ", ";
    }
    $i++;
}
echo ")<br>";

// Data kedua (Barry => 65)
$keys = array_keys($weight);
echo "Data kedua: " . $weight[$keys[1]];
?>