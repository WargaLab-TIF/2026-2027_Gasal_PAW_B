```````<?php
$a = array("A");
echo 'A    rray awal: ("' . implode('", "', $a) . '")<br>';
array_push($a, "B");
echo "Hasil array_push: " . implode(" ", $a) . "<br><br>";

$a1 = array("A", "B");
$a2 = array("C");
echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
$merge = array_merge($a1, $a2);
echo "Hasil array_merge: " . implode(" ", $merge) . "<br><br>";

$xy = array("x" => 1, "y" => 2);
echo 'Array awal: ("x" => 1, "y" => 2)<br>';
$values = array_values($xy);
echo "Hasil array_values: " . implode(" ", $values) . "<br><br>";

$abc = array("A", "B", "C");
echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
echo "Hasil array_search: " . array_search("B", $abc) . "<br><br>";

$campur = array(0, 1, false, 2, "", 3, "array");
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
$filter = array_filter($campur);
echo "Hasil array_filter: " . implode(" ", $filter) . "<br><br>";

$angka = array(3, 1, 2);
echo "Array awal: (3, 1, 2)<br>";
$s = $angka;
sort($s);
echo "Hasil sort: " . implode(" ", $s) . "<br>";
$r = $angka;
rsort($r);
echo "Hasil rsort: " . implode(" ", $r) . "<br><br>";

$age = array("Peter" => 35, "Ben" => 37, "Joe" => 43);
echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

$t = $age;
asort($t);
echo "Hasil asort: ";
foreach ($t as $k => $v) echo "$k=> $v, ";
echo "<br>";

$t = $age;
ksort($t);
echo "Hasil ksort: ";
foreach ($t as $k => $v) echo "$k=> $v, ";
echo "<br>";

$t = $age;
arsort($t);
echo "Hasil arsort: ";
foreach ($t as $k => $v) echo "$k=> $v, ";
echo "<br>";

$t = $age;
krsort($t);
echo "Hasil krsort: ";
foreach ($t as $k => $v) echo "$k=> $v, ";
echo "<br>";
?>