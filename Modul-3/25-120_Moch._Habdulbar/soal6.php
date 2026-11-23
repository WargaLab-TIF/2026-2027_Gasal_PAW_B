<?php

//array_push() : menambah data di akhir array
$a = array("A");
echo "Array awal: (A)<br>";
array_push($a, "B");
echo "Hasil array_push: ";
foreach ($a as $v) { echo $v . " "; }

//array_merge() : menggabungkan dua array
$a1 = array("A","B");
$a2 = array("C");
echo "<br><br>Array awal: (A, B) digabung dengan (C)<br>";
$gabung = array_merge($a1, $a2);
echo "Hasil array_merge: ";
foreach ($gabung as $v) { echo $v . " "; }

//array_values() : mengambil semua nilai array (kunci dibuang)
$b = array("x"=>1,"y"=>2);
echo "<br><br>Array awal: (x => 1, y => 2)<br>";
$nilai = array_values($b);
echo "Hasil array_values: ";
foreach ($nilai as $v) { echo $v . " "; }

//array_search() : mencari data dan menampilkan indeksnya
$c = array("A","B","C");
echo "<br><br>Mencari B pada array: (A, B, C)<br>";
echo "Hasil array_search: " . array_search("B", $c);

//array_filter() : membuang data yang kosong / false / 0
$d = array(0, 1, false, 2, "", 3, "array");
echo "<br><br>Array awal: (0, 1, false, 2, \"\", 3, \"array\")<br>";
$bersih = array_filter($d);
echo "Hasil array_filter: ";
foreach ($bersih as $v) { echo $v . " "; }

//sort() dan rsort() : mengurutkan array terindeks
$e = array(3, 1, 2);
echo "<br><br>Array awal: (3, 1, 2)<br>";
sort($e);
echo "Hasil sort: ";
foreach ($e as $v) { echo $v . " "; }
rsort($e);
echo "<br>Hasil rsort: ";
foreach ($e as $v) { echo $v . " "; }

//pengurutan array asosiatif
$age = array("Peter"=>35,"Ben"=>37,"Joe"=>43);
echo "<br><br>Array awal: (Peter=>35, Ben=>37, Joe=>43)<br>";

// asort() : urut berdasarkan nilai, kecil ke besar
$t = $age;
asort($t);
echo "Hasil asort: ";
foreach ($t as $k => $v) { echo $k . "=> " . $v . ", "; }

// ksort() : urut berdasarkan kunci, A ke Z
$t = $age;
ksort($t);
echo "<br>Hasil ksort: ";
foreach ($t as $k => $v) { echo $k . "=> " . $v . ", "; }

// arsort() : urut berdasarkan nilai, besar ke kecil
$t = $age;
arsort($t);
echo "<br>Hasil arsort: ";
foreach ($t as $k => $v) { echo $k . "=> " . $v . ", "; }

// krsort() : urut berdasarkan kunci, Z ke A
$t = $age;
krsort($t);
echo "<br>Hasil krsort: ";
foreach ($t as $k => $v) { echo $k . "=> " . $v . ", "; }

?>