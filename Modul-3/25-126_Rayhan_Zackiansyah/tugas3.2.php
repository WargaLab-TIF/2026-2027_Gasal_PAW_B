<?php
// 3.2
echo "Soal 3.2<br>";

$weight = array(
    "Andy" => "70",
    "Barry" => "65",
    "Charlie" => "75"
);

echo 'weight = (';
foreach ($weight as $nama => $berat) {
    echo '"' . $nama . '"=>"' . $berat . '"';
    if ($nama != "Charlie") {
        echo ", ";
    }
}
echo ")<br>";

echo "Data kedua: " . $weight["Barry"];
?>