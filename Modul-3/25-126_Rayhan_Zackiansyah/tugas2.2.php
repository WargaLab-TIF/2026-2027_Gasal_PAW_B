<?php
// 2.2
echo "Soal 2.2<br><br>";

$vegies = array("Carrot", "Broccoli", "Spinach");
$panjangVegies = count($vegies);

for ($x = 0; $x < $panjangVegies; $x++) {
    echo $vegies[$x];
    echo "<br>";
}

// Jawaban:
// Saya cukup memodifikasi skrip yang sudah ada dengan menambahkan
// array $vegies dan perulangan for untuk menampilkan data sayuran.
// Alasannya, struktur program pada soal 2.1 dapat digunakan kembali
// karena cara menampilkan data array sayuran sama dengan data buah.
?>