<?php
$fruits = array("Avocado","Blueberry","Cherry");

//2.1
$tambah = array("Durian", "Elderberry", "Fig", "Grape", "Honeydew");

for ($i = 0; $i <= 4; $i++) {
  $fruits[] = $tambah[$i];
}

$arrlength = count($fruits);

echo "Panjang array saat ini: " . $arrlength . "<br><br>";

for($x = 0; $x < $arrlength; $x++) {
	echo $fruits[$x];
	echo "<br>";
}

echo "<br>Penjelasan: for pada baris, before 5-8, after 15-18 tidak perlu diubah karena untuk memasukkan data baru pada array harus membuat perulangan for lagi dan juga perulangan for pada baris 15-18 itu hanya untuk menampilkan semua isi dari array";

//2.2
echo "<br><br>";
$vegies = array("Carrot", "Broccoli", "Spinach");

for($a = 0; $a < count($vegies); $a++) {
	echo $vegies[$a];
	echo "<br>";
}

echo "<br>Penjelasan: memodifikasi code yang sudah dari dari variabel x menjadi a dan arrlength menjadi vegies";
?>