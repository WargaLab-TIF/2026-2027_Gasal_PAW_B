<?php
$vegies = array("Carrot", "Broccoli", "Spinach");
$arrlength = count($vegies);

for($x = 0; $x < $arrlength; $x++) {
    echo $vegies[$x];
    echo "<br>";
}
// apakah perlu membuat skrip baru atau cukup memodifikasi skrip yang sudah ada?

// cukup memodifikasi skrip yang sudah ada dengan mengganti nama array menjadi $vegies dan isi datanya. struktur perulangan for dapat digunakan kembali karena cara mengakses array terindeks tetap sama.
?>