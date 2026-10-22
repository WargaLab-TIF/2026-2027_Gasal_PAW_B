<?php
$height = array("Andy" => "176", "Barry" => "165", "Charlie" => "170");

$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

echo "height = ( ";

foreach ($height as $nama => $tinggi) {
    echo "$nama => $tinggi, ";
}

echo ")";
echo "<br>Nilai dengan indeks terakhir: " . $height["Harry"];

unset($height["Barry"]);

echo "<br><br>height = ( ";

foreach ($height as $nama => $tinggi) {
    echo "$nama => $tinggi, ";
}

echo ")";
echo "<br>Nilai dengan indeks terakhir setelah dihapus: " . $height["Harry"];
?>