<?php
$matkul = ["PTI", "ALPRO", "DPW", "STRUKDAT", "JARKOM", "PAW", "PSBF", "RPL"];

$praktikum = ["JARKOM", "PAW"];

for ($i = 0; $i < count($matkul); $i++) {
    if (in_array($matkul[$i], $praktikum)) {
        print("Saya sedang mengambil matkul " . $matkul[$i] . " termasuk praktikumnya<br>");
    }
    elseif ($matkul[$i] == "PSBF" || $matkul[$i] == "RPL") {
        echo "Saya belum mengambil matkul " . $matkul[$i] . "<br>";
    }
    else {
        echo "Saya sudah mengambil matkul " . $matkul[$i] . " semester lalu<br>";
    }

}
?>