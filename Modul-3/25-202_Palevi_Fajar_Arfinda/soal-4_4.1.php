<?php

$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");

$height["David"]  = "180";
$height["Ethan"]  = "172";
$height["Frank"]  = "168";
$height["George"] = "175";
$height["Harry"]  = "182";

function tampil($arr) {
    $jumlah = count($arr);
    $no = 0;
    echo '(';
    foreach ($arr as $k => $v) {
        echo '"' . $k . '"=>"' . $v . '"';
        $no++;
        if ($no < $jumlah) { echo ', '; }
    }
    echo ')';
}

echo "height = "; tampil($height); echo "<br><br>";

foreach ($height as $nama => $tinggi) {
    echo $nama . " is " . $tinggi . " cm tall.";
    echo "<br>";
}
?>
