
<?php
// 3.1
echo "Soal 3.1<br>";

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
    echo '"' . $nama . '"=>"' . $tinggi . '"';
    if ($nama != "Harry") {
        echo ", ";
    }
}
echo ")<br>";

echo "Nilai dengan indeks terakhir: " . end($height) . "<br><br>";

unset($height["Charlie"]);

echo "height = (";
foreach ($height as $nama => $tinggi) {
    echo '"' . $nama . '"=>"' . $tinggi . '"';
    if ($nama != "Harry") {
        echo ", ";
    }
}
echo ")<br>";

echo "Nilai dengan indeks terakhir setelah dihapus: " . end($height) . "<br><br>";
?>