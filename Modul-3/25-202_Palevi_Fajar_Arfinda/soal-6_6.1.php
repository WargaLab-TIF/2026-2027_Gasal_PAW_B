<?php
$a = array("A");
echo 'Array awal: ("A")<br>';
array_push($a, "B");
echo "Hasil array_push: ";
foreach ($a as $v) { echo $v . " "; }
echo "<br><br>";

$a1 = array("A", "B");
$a2 = array("C");
echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
$gabung = array_merge($a1, $a2);
echo "Hasil array_merge: ";
foreach ($gabung as $v) { echo $v . " "; }
echo "<br><br>";

$assoc = array("x" => 1, "y" => 2);
echo 'Array awal: ("x" => 1, "y" => 2)<br>';
$nilai = array_values($assoc);
echo "Hasil array_values: ";
foreach ($nilai as $v) { echo $v . " "; }
echo "<br><br>";

$cari = array("A", "B", "C");
echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
echo "Hasil array_search: " . array_search("B", $cari) . "<br><br>";

$campur = array(0, 1, false, 2, "", 3, "array");
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
$hasil = array_filter($campur);
echo "Hasil array_filter: ";
foreach ($hasil as $v) { echo $v . " "; }
echo "<br><br>";

$angka = array(3, 1, 2);
echo "Array awal: (3, 1, 2)<br>";
sort($angka);
echo "Hasil sort: ";
foreach ($angka as $v) { echo $v . " "; }
echo "<br>";
rsort($angka);
echo "Hasil rsort: ";
foreach ($angka as $v) { echo $v . " "; }
echo "<br><br>";

$age = array("Peter" => "35", "Ben" => "37", "Joe" => "43");
echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

$t = $age; asort($t);
echo "Hasil asort: ";  foreach ($t as $k => $v) { echo "$k=> $v, "; } echo "<br>";

$t = $age; ksort($t);
echo "Hasil ksort: ";  foreach ($t as $k => $v) { echo "$k=> $v, "; } echo "<br>";

$t = $age; arsort($t);
echo "Hasil arsort: "; foreach ($t as $k => $v) { echo "$k=> $v, "; } echo "<br>";

$t = $age; krsort($t);
echo "Hasil krsort: "; foreach ($t as $k => $v) { echo "$k=> $v, "; } echo "<br>";
?>
