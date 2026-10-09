<?php
$fruits = array("Avocado", "Blueberry", "Cherry");
for($i = 1; $i <= 5; $i++) {
    $fruits[] = "Buah Tambahan ".$i;
}

$arrlength = count($fruits);
echo "Panjang array saat ini: ".$arrlength;
echo "<br><br>";

for($x = 0; $x<$arrlength; $x++) {
    echo $fruits[$x]."<br>";
}
//apakah skrip perulangan for pada baris #5-#8 perlu diubah agar seluruh data tampil?

//tidak perlu diubah, karena nilai $arrlength diperoleh dari count($fruits). Setelah lima data ditambahkan, jumlah array menjadi 8, sehingga perulangan otomatis menampilkan seluruh data dari indeks 0 sampai 7.
?>