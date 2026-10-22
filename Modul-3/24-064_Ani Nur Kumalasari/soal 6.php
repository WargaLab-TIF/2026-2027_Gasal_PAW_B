<?php

// 1. array_push()
$buah = array("A");
array_push($buah, "B");

echo 'Array awal: ("A")<br>';
echo "Hasil array_push: ";

foreach ($buah as $data) {
    echo $data . " ";
}
echo "<br><br>";


// 2. array_merge()
$array1 = array("A", "B");
$array2 = array("C");
$gabungan = array_merge($array1, $array2);

echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
echo "Hasil array_merge: ";

foreach ($gabungan as $data) {
    echo $data . " ";
}
echo "<br><br>";


// 3. array_values()
$data = array("x" => 1, "y" => 2);
$nilai = array_values($data);

echo 'Array awal: ("x" => 1, "y" => 2)<br>';
echo "Hasil array_values: ";

foreach ($nilai as $data) {
    echo $data . " ";
}
echo "<br><br>";


// 4. array_search()
$huruf = array("A", "B", "C");
$cari = array_search("B", $huruf);

echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
echo "Hasil array_search: ";
echo $cari;
echo "<br><br>";


// 5. array_filter()
$angka = array(0, 1, false, 2, "", 3, "array");
$filter = array_filter($angka);

echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
echo "Hasil array_filter: ";

foreach ($filter as $data) {
    echo $data . " ";
}
echo "<br><br>";


// 6. Sorting array numerik
$angka2 = array(3, 1, 2);

echo "Array awal: (3, 1, 2)<br>";

sort($angka2);
echo "Hasil sort: ";
foreach ($angka2 as $data) {
    echo $data . " ";
}
echo "<br>";

rsort($angka2);
echo "Hasil rsort: ";
foreach ($angka2 as $data) {
    echo $data . " ";
}
echo "<br><br>";

// Sorting array asosiatif
$nilaiSiswa = array(
    "Peter" => 35,
    "Ben" => 37,
    "Joe" => 43
);

echo '<br>Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

// asort: urut berdasarkan nilai terkecil ke terbesar
$temp = $nilaiSiswa;
asort($temp);
echo "Hasil asort: ";
foreach ($temp as $nama => $nilai) {
    echo $nama . "=> " . $nilai . ", ";
}
echo "<br>";

// ksort: urut berdasarkan nama A-Z
$temp = $nilaiSiswa;
ksort($temp);
echo "Hasil ksort: ";
foreach ($temp as $nama => $nilai) {
    echo $nama . "=> " . $nilai . ", ";
}
echo "<br>";

// arsort: urut berdasarkan nilai terbesar ke terkecil
$temp = $nilaiSiswa;
arsort($temp);
echo "Hasil arsort: ";
foreach ($temp as $nama => $nilai) {
    echo $nama . "=> " . $nilai . ", ";
}
echo "<br>";

// krsort: urut berdasarkan nama Z-A
$temp = $nilaiSiswa;
krsort($temp);
echo "Hasil krsort: ";
foreach ($temp as $nama => $nilai) {
    echo $nama . "=> " . $nilai . ", ";
}
?>