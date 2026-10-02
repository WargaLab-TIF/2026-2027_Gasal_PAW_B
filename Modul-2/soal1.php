<?php

$arr = ["PTI", "ALPRO", "DPW", "STRUKDAT", "JARKOM", "PAW", "PSBF", "RPL"];
$praktikum = ["JARKOM", "PAW"];

for ($i = 0; $i < count($arr); $i++) {

    if ($arr[$i] == $praktikum[0] || $arr[$i] == $praktikum[1]) {
        echo "Saya sedang mengambil Matkul " . $arr[$i] . " termasuk praktikumnya<br>";
    }
    elseif ($i == 6 || $i == 7) {
        echo "Saya belum mengambil Matkul " . $arr[$i] . "<br>";
    }
    else {
        echo "Saya sudah mengambil Matkul " . $arr[$i] . " semester lalu<br>";
    }

}

?>