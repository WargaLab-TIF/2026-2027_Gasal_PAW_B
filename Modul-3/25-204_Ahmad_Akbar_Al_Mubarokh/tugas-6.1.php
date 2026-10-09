<?php
$a = array("A");
echo 'Array awal: ("A")<br>';
array_push($a, "B");
echo "Hasil array_push: ";
foreach ($a as $v) {
    echo $v . " ";
}
echo "<br><br>";

$b1 = array("A", "B");
$b2 = array("C");
$hasil = array_merge($b1, $b2);
echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
echo "Hasil array_merge: ";
foreach ($hasil as $v) {
    echo $v . " ";
}
echo "<br><br>";

$c = array("x" => 1, "y" => 2);
$hasil = array_values($c);
echo 'Array awal: ("x" => 1, "y" => 2)<br>';
echo "Hasil array_values: ";
foreach ($hasil as $v) {
    echo $v . " ";
}
echo "<br><br>";

$d = array("A", "B", "C");
$hasil = array_search("B", $d);
echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
echo "Hasil array_search: " . $hasil;
echo "<br><br>";

$e = array(0, 1, false, 2, "", 3, "array");
$hasil = array_filter($e);
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
echo "Hasil array_filter: ";
foreach ($hasil as $v) {
    echo $v . " ";
}
echo "<br><br>";

$f = array(3, 1, 2);
echo "Array awal: (3, 1, 2)<br>";
sort($f);
echo "Hasil sort: ";
foreach ($f as $v) {
    echo $v . " ";
}
echo "<br>";
rsort($f);
echo "Hasil rsort: ";
foreach ($f as $v) {
    echo $v . " ";
}
echo "<br><br>";

$age = array("Peter" => 35, "Ben" => 37, "Joe" => 43);
echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

asort($age);
echo "Hasil asort: ";
foreach ($age as $k => $v) {
    echo $k . "=> " . $v . ", ";
}
echo "<br>";

ksort($age);
echo "Hasil ksort: ";
foreach ($age as $k => $v) {
    echo $k . "=> " . $v . ", ";
}
echo "<br>";

arsort($age);
echo "Hasil arsort: ";
foreach ($age as $k => $v) {
    echo $k . "=> " . $v . ", ";
}
echo "<br>";

krsort($age);
echo "Hasil krsort: ";
foreach ($age as $k => $v) {
    echo $k . "=> " . $v . ", ";
}
echo "<br>";
?>