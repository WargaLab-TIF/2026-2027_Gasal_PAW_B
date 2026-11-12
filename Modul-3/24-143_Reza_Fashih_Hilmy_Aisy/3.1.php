<?php
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");

$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

echo 'height = ( ';
foreach ($height as $nama => $tinggi) {
    echo '"' . $nama . '"=>"' . $tinggi . '"';
    if ($nama != "Harry") {
        echo ', ';
    }
}
echo ')<br>';

foreach ($height as $nama => $tinggi) {
}
echo "Nilai dengan indeks terakhir: " . $tinggi . "<br><br>";

unset($height["Barry"]);

echo 'height = ( ';
foreach ($height as $nama => $tinggi) {
    echo '"' . $nama . '"=>"' . $tinggi . '"';
    if ($nama != "Harry") {
        echo ', ';
    }
}
echo ')<br>';

foreach ($height as $nama => $tinggi) {
}
echo "Nilai dengan indeks terakhir setelah dihapus: " . $tinggi;
?>