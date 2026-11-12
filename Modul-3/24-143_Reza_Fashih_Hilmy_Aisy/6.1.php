<?php

$a = array("A");
echo 'Array awal: ("A")<br>';

array_push($a, "B");
echo "Hasil array_push: ";
foreach ($a as $nilai) {
    echo $nilai . " ";
}
echo "<br><br>";


$a = array("A", "B");
$b = array("C");

echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';

$c = array_merge($a, $b);
echo "Hasil array_merge: ";
foreach ($c as $nilai) {
    echo $nilai . " ";
}
echo "<br><br>";


$a = array("x" => 1, "y" => 2);

echo 'Array awal: ("x" => 1, "y" => 2)<br>';

$b = array_values($a);
echo "Hasil array_values: ";
foreach ($b as $nilai) {
    echo $nilai . " ";
}
echo "<br><br>";


$a = array("A", "B", "C");

echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
echo "Hasil array_search: " . array_search("B", $a);
echo "<br><br>";


$a = array(0, 1, false, 2, "", 3, "array");

echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';

$b = array_filter($a);
echo "Hasil array_filter: ";
foreach ($b as $nilai) {
    echo $nilai . " ";
}
echo "<br><br>";


$a = array(3, 1, 2);

echo "Array awal: (3, 1, 2)<br>";

sort($a);
echo "Hasil sort: ";
foreach ($a as $nilai) {
    echo $nilai . " ";
}
echo "<br>";

$a = array(3, 1, 2);
rsort($a);
echo "Hasil rsort: ";
foreach ($a as $nilai) {
    echo $nilai . " ";
}
echo "<br><br>";


$a = array("Peter" => 35, "Ben" => 37, "Joe" => 43);

echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

asort($a);
echo "Hasil asort: ";
foreach ($a as $nama => $umur) {
    echo $nama . "=> " . $umur . ", ";
}
echo "<br>";

ksort($a);
echo "Hasil ksort: ";
foreach ($a as $nama => $umur) {
    echo $nama . "=> " . $umur . ", ";
}
echo "<br>";

arsort($a);
echo "Hasil arsort: ";
foreach ($a as $nama => $umur) {
    echo $nama . "=> " . $umur . ", ";
}
echo "<br>";

krsort($a);
echo "Hasil krsort: ";
foreach ($a as $nama => $umur) {
    echo $nama . "=> " . $umur . ", ";
}
?>