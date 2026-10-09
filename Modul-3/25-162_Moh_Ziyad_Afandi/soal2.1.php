<?php
$fruits = array("Avocado", "Blueberry", "Cherry");

$buahBaru = array("Durian", "Elderberry", "Fig", "Grape", "Honeydew");
for ($i = 0; $i < count($buahBaru); $i++) {
    $fruits[] = $buahBaru[$i];
}

$arrlength = count($fruits);

echo "Panjang array: " . $arrlength . "<br>";

/*
 * PENJELASAN: Apakah perulangan for pada baris #5-#8 perlu diubah?
 *
 * Tidak perlu diubah.
 *
 * Alasan:
 * 1. Kondisi perulangan ($x < $arrlength) tidak menulis jumlah data secara
 *    langsung (hardcode), tetapi memakai variabel $arrlength yang nilainya
 *    berasal dari count($fruits).
 * 2. Karena $arrlength = count($fruits) dijalankan setelah lima data baru
 *    ditambahkan, nilainya otomatis menjadi 8, sehingga perulangan
 *    menampilkan seluruh data (indeks 0 sampai 7).
 * 3. Yang perlu diperhatikan hanya urutan penulisan: jika $arrlength dihitung
 *    sebelum penambahan data, nilainya tetap 3 dan hanya tiga data pertama
 *    yang tampil.
 */
for ($x = 0; $x < $arrlength; $x++) {
    echo $fruits[$x];
    echo "<br>";
}
?>	