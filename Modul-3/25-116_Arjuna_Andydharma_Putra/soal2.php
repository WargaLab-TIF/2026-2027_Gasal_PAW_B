<?php
// 2.1 Tambahkan lima data baru dengan perulangan for
$fruits = array("Avocado", "Blueberry", "Cherry");

for ($i = 1; $i <= 5; $i++) {
    $fruits[] = "Buah Tambahan " . $i;
}

$arrlength = count($fruits);
echo "Panjang array saat ini: " . $arrlength . "<br><br>";

for ($x = 0; $x < $arrlength; $x++) {
    echo $fruits[$x];
    echo "<br>";
}

echo "<br>";
echo "Penjelasan: Skrip perulangan for pada baris #5-#8 TIDAK perlu diubah. ";
echo "Alasannya karena \$arrlength = count(\$fruits) dihitung setelah data baru ditambahkan, ";
echo "sehingga batas perulangan otomatis menyesuaikan jumlah elemen yang baru (8 elemen).";
echo "<br><br>";

// 2.2 Array baru $veggies
$veggies = array("Carrot", "Broccoli", "Spinach");

for ($x = 0; $x < count($veggies); $x++) {
    echo $veggies[$x];
    echo "<br>";
}

echo "<br>";
echo "Penjelasan: Saya membuat skrip baru. ";
echo "Alasannya karena array yang digunakan berbeda (\$veggies), ";
echo "sehingga perlu deklarasi array baru dan perulangan tersendiri. ";
echo "Jika hanya memodifikasi skrip \$fruits, data akan tercampur dan tidak sesuai permintaan soal.";
?>