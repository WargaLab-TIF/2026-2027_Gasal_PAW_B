<?php
// 4.1 Tambahkan lima data baru ke $height, tampilkan seluruh data dengan perulangan
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");

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
echo ")<br><br>";

foreach ($height as $nama => $tinggi) {
    echo $nama . " is " . $tinggi . " cm tall.<br>";
}

echo "<br>";

// 4.2 Array baru $weight, tampilkan dengan struktur perulangan FOR
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
echo ")<br><br>";

$keys = array_keys($weight);
for ($i = 0; $i < count($weight); $i++) {
    $nama = $keys[$i];
    echo $nama . " is " . $weight[$nama] . " kg.<br>";
}
?>