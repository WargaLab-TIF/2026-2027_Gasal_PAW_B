	<?php
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

foreach ($height as $nama => $tinggi) {
    echo '"' . $nama . '"=>"' . $tinggi . '",';
}

echo ")<br>";

$indeks_terakhir = array_key_last($height);
echo "Nilai dengan indeks terakhir" . $height[$indeks_terakhir] . "<br><br>";

unset($height["Barry"]);

echo "height = (";

foreach ($height as $nama => $tinggi) {
    echo '"' . $nama . '"=>"' . $tinggi . '",';

}

echo ")<br>";

$indeks_terakhir = array_key_last($height);
echo "Nilai dengan indeks terakhir setelah dihapus: ";
echo $height[$indeks_terakhir];
?>