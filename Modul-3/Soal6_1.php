<?php

$a = array("A");
echo 'Array awal: ("A")<br>';
array_push($a, "B");
echo 'Hasil array_push: ' . implode(" ", $a) . '<br><br>';

$a = array("A", "B");
$b = array("C");
echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
echo 'Hasil array_merge: ' . implode(" ", array_merge($a, $b)) . '<br><br>';

$a = array("x" => 1, "y" => 2);
echo 'Array awal: ("x" => 1, "y" => 2)<br>';
echo 'Hasil array_values: ' . implode(" ", array_values($a)) . '<br><br>';

$a = array("A", "B", "C");
echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
echo 'Hasil array_search: ' . array_search("B", $a) . '<br><br>';

$a = array(0, 1, false, 2, "", 3, "array");
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
echo 'Hasil array_filter: ' . implode(" ", array_filter($a)) . '<br><br>';

$a = array(3, 1, 2);
echo 'Array awal: (3, 1, 2)<br>';
$b = $a;
sort($b);
echo 'Hasil sort: ' . implode(" ", $b) . '<br>';
rsort($a);
echo 'Hasil rsort: ' . implode(" ", $a) . '<br><br>';

$a = array("Peter" => 35, "Ben" => 37, "Joe" => 43);
echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

asort($a);
echo 'Hasil asort: ';
foreach ($a as $k => $v) echo "$k=> $v, ";
echo '<br>';

ksort($a);
echo 'Hasil ksort: ';
foreach ($a as $k => $v) echo "$k=> $v, ";
echo '<br>';

arsort($a);
echo 'Hasil arsort: ';
foreach ($a as $k => $v) echo "$k=> $v, ";
echo '<br>';

krsort($a);
echo 'Hasil krsort: ';
foreach ($a as $k => $v) echo "$k=> $v, ";
?>