<?php
$vegies = array("Carrot", "Broccoli", "Spinach");
$arrlength = count($vegies);

echo "Jumlah data sayuran: " . $arrlength . "<br><br>";

echo "Daftar Sayuran:<br>";
for ($x = 0; $x < $arrlength; $x++) {
    echo $vegies[$x];
    echo "<br>";
}

// menurut saya cuku modifikasi di bagian pemanggilan variable beserta indeks iterasinya
?>