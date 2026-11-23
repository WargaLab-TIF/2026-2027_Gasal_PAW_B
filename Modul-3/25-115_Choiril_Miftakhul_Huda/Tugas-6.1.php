<?php

$array1 = array("A");
echo 'Array awal: ("A")<br>';
array_push($array1, "B");
echo 'Hasil array_push: ' . implode(' ', $array1) . '<br><br>';

$array2 = array("A", "B");
$array3 = array("C");
echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
$gabung = array_merge($array2, $array3);
echo 'Hasil array_merge: ' . implode(' ', $gabung) . '<br><br>';

$data = array("x" => 1, "y" => 2);
echo 'Array awal: ("x" => 1, "y" => 2)<br>';
$keluar = array_values($data);
echo 'Hasil array_values: ' . implode(' ', $keluar) . '<br><br>';

$array4 = array("A", "B", "C");
echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
$cari = array_search("B", $array4);
echo 'Hasil array_search: ' . $cari . '<br><br>';

$array5 = array(0, 1, false, 2, "", 3, "array");
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
$hasil = array_filter($array5);
echo 'Hasil array_filter: ' . implode(' ', $hasil) . '<br><br>';

$array6 = array(3, 1, 2);
echo 'Array awal: (3, 1, 2)<br>';
$a = $array6;
sort($a);
echo 'Hasil sort: ' . implode(' ', $a) . '<br>';

$b = $array6;
rsort($b);
echo 'Hasil rsort: ' . implode(' ', $b) . '<br><br>';

$umur = array("Peter" => 35, "Ben" => 37, "Joe" => 43);
echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

$c = $umur;
asort($c);
$res1 = array();
foreach ($c as $k => $v) $res1[] = "$k=> $v";
echo 'Hasil asort: ' . implode(', ', $res1) . '<br>';

$d = $umur;
ksort($d);
$res2 = array();
foreach ($d as $k => $v) $res2[] = "$k=> $v";
echo 'Hasil ksort: ' . implode(', ', $res2) . '<br>';

$e = $umur;
arsort($e);
$res3 = array();
foreach ($e as $k => $v) $res3[] = "$k=> $v";
echo 'Hasil arsort: ' . implode(', ', $res3) . '<br>';

$f = $umur;
krsort($f);
$res4 = array();
foreach ($f as $k => $v) $res4[] = "$k=> $v";
echo 'Hasil krsort: ' . implode(', ', $res4) . '<br>';