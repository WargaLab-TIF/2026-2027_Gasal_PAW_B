<?php
$fruits = array("Avocado", "Blueberry", "Cherry");
$fruits_tambahan = array("Durian", "Elderberry", "Fig", "Grape", "Mango");

for ($i = 0; $i < count($fruits_tambahan); $i++) {
    $fruits[] = $fruits_tambahan[$i];
}

$arrlength = count($fruits);

echo "Jumlah data buah: " . $arrlength . "<br><br>";

echo "Daftar Buah:<br>";
for ($x = 0; $x < $arrlength; $x++) {
    echo $fruits[$x];
    echo "<br>";
}

//Tidak perlu mengubah skrip perulangannya. karena variabel $arrlength sebagai range harus ada untuk menghitung jumlah data setelah penambahan, kemudian perulangan dapat menampilkan seluruh isi array termasuk lima data baru.
?>