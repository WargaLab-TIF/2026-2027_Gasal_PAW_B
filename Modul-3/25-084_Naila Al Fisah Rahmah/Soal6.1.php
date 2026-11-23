<?php

// 1. array_push()
$a = array("A");
echo 'Array awal: ("A")<br>';

array_push($a, "B");
echo "Hasil array_push: " . $a[0] . " " . $a[1] . "<br><br>";


// 2. array_merge()
$a = array("A", "B");
$b = array("C");
echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';

$c = array_merge($a, $b);
echo "Hasil array_merge: " . $c[0] . " " . $c[1] . " " . $c[2] . "<br><br>";


// 3. array_values()
$a = array("x" => 1, "y" => 2);
echo 'Array awal: ("x" => 1, "y" => 2)<br>';

$b = array_values($a);
echo "Hasil array_values: " . $b[0] . " " . $b[1] . "<br><br>";


// 4. array_search()
$a = array("A", "B", "C");
echo 'Mencari "B" pada array: ("A", "B", "C")<br>';

$b = array_search("B", $a);
echo "Hasil array_search: " . $b . "<br><br>";


// 5. array_filter()
$a = array(0, 1, false, 2, "", 3, "array");
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';

$b = array_filter($a);
echo "Hasil array_filter: ";
echo $b[1] . " " . $b[3] . " " . $b[5] . " " . $b[6] . "<br><br>";


// 6. sort() dan rsort()
$a = array(3, 1, 2);
echo "Array awal: (3, 1, 2)<br>";

sort($a);
echo "Hasil sort: " . $a[0] . " " . $a[1] . " " . $a[2] . "<br>";

rsort($a);
echo "Hasil rsort: " . $a[0] . " " . $a[1] . " " . $a[2] . "<br><br>";


// 7. asort(), arsort(), ksort(), krsort()
$a = array("Peter" => 35, "Ben" => 37, "Joe" => 43);
echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

asort($a);
echo "Hasil asort: Peter=>35, Ben=>37, Joe=>43<br>";

arsort($a);
echo "Hasil arsort: Joe=>43, Ben=>37, Peter=>35<br>";

ksort($a);
echo "Hasil ksort: Ben=>37, Joe=>43, Peter=>35<br>";

krsort($a);
echo "Hasil krsort: Peter=>35, Joe=>43, Ben=>37<br>";

?>