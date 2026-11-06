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
$height["Henry"] = "182";

echo 'height = ( ';
foreach ($height as $nama => $tinggi) {
    echo '"' . $nama .'"' . " => " .'"' . $tinggi .'"'. ",";
}
echo ')';

$indeks_terakhir = array_key_last($height);

echo "<br>Nilai dengan indeks terakhir setelah di hapus: ";
echo $height[$indeks_terakhir] . " cm";

echo "<br><br>";
unset($height["Frank"]);

echo 'height = ( ';
foreach ($height as $nama => $tinggi) {
    echo '"' . $nama .'"' . " => " .'"' . $tinggi .'"'. ",";
}
echo ')';

$indeks_terakhir = array_key_last($height);

echo "<br>Nilai dengan indeks terakhir: ";
echo $height[$indeks_terakhir] . " cm";
?>
```
