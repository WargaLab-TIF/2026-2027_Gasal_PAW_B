<?php
$height = array("Andy" => "176", "Barry" => "165", "Charlie" => "170");

$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

echo 'height = (';
$i = 0;
foreach ($height as $k => $v) {
    echo '"' . $k . '"=>"' . $v . '"';
    if ($i < count($height) - 1) {
        echo ', ';
    }
    $i++;
}
echo ')<br>';
echo "Nilai dengan indeks terakhir: " . end($height) . "<br><br>";

unset($height["Barry"]);

echo 'height = (';
$i = 0;
foreach ($height as $k => $v) {
    echo '"' . $k . '"=>"' . $v . '"';
    if ($i < count($height) - 1) {
        echo ', ';
    }
    $i++;
}
echo ')<br>';
echo "Nilai dengan indeks terakhir setelah dihapus: " . end($height);
?>