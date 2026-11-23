<?php
//2.1
echo "Soal 2.1<br>";
$fruits = array("Avocado", "Blueberry", "Cherry");
$tambahbuah = array("Mango", "Orange", "Banana", "Apple", "Grape");

for ($i = 0; $i < count($tambahbuah); $i++) {
    $fruits[] = $tambahbuah[$i];
}

$length = count($fruits);

echo "Panjang array saat ini: " . $length . "<br><br>";

for ($x = 0; $x < $length; $x++) {
    echo $fruits[$x];
    echo "<br>";
}

// Perulangan for pada baris #5–#8 perlu diubah agar seluruh data buah yang sudah ditambahkan dapat ditampilkan
// Hal ini karena variabel $arrlength pada baris #3 hanya menghitung jumlah elemen array $fruits sebelum
// penambahan data, sehingga jumlahnya tidak ikut bertambah secara otomatis. Oleh karena itu, kondisi perulangan dapat menggunakan count($fruits) agar seluruh data buah yang ada di dalam array dapat ditampilkan.

?>