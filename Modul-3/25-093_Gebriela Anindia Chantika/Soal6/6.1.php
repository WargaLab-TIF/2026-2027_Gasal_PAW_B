<?php
$a = array("A");
echo "Array awal: (\"A\")<br>";
array_push($a, "B");
echo "Hasil array_push: ";
foreach ($a as $val) {
    echo $val . " ";
}
echo "<br><br>";

$b1 = array("A", "B");
$b2 = array("C");
echo "Array: (\"A\", \"B\") digabung dengan (\"C\")<br>";
$b_gabung = array_merge($b1, $b2);
echo "Hasil array_merge: ";
foreach ($b_gabung as $val) {
    echo $val . " ";
}
echo "<br><br>";

$c = array("x" => 1, "y" => 2);
echo "Array awal: (\"x\" => 1, \"y\" => 2)<br>";
$c_val = array_values($c);
echo "Hasil array_values: ";
foreach ($c_val as $val) {
    echo $val . " ";
}
echo "<br><br>";

$d = array("A", "B", "C");
echo "Mencari \"B\" pada array: (\"A\", \"B\", \"C\")<br>";
$d_cari = array_search("B", $d);
echo "Hasil array_search: " . $d_cari . "<br><br>";

$e = array(0, 1, false, 2, "", 3, "array");
echo "Array awal: (0, 1, false, 2, \"\", 3, \"array\")<br>";
$e_filter = array_filter($e);
echo "Hasil array_filter: ";
foreach ($e_filter as $val) {
    echo $val . " ";
}
echo "<br><br>";

$f1 = array(3, 1, 2);
$f2 = array(3, 1, 2);
echo "Array awal: (3, 1, 2)<br>";
sort($f1);
echo "Hasil sort: ";
for ($i = 0; $i < count($f1); $i++) {
    echo $f1[$i] . " ";
}
echo "<br>";

rsort($f2);
echo "Hasil rsort: ";
for ($i = 0; $i < count($f2); $i++) {
    echo $f2[$i] . " ";
}
echo "<br><br>";

$g = array("Peter" => 35, "Ben" => 37, "Joe" => 43);
echo "Array awal: (\"Peter\"=>35, \"Ben\"=>37, \"Joe\"=>43)<br>";

$g1 = $g;
asort($g1);
echo "Hasil asort: ";
$i = 0;
foreach ($g1 as $k => $v) {
    echo $k . "=>" . $v;
    if ($i < count($g1) - 1) { echo ", "; }
    $i++;
}
echo "<br>";

$g2 = $g;
ksort($g2);
echo "Hasil ksort: ";
$i = 0;
foreach ($g2 as $k => $v) {
    echo $k . "=>" . $v;
    if ($i < count($g2) - 1) { echo ", "; }
    $i++;
}
echo "<br>";

$g3 = $g;
arsort($g3);
echo "Hasil arsort: ";
$i = 0;
foreach ($g3 as $k => $v) {
    echo $k . "=>" . $v;
    if ($i < count($g3) - 1) { echo ", "; }
    $i++;
}
echo "<br>";

$g4 = $g;
krsort($g4);
echo "Hasil krsort: ";
$i = 0;
foreach ($g4 as $k => $v) {
    echo $k . "=>" . $v;
    if ($i < count($g4) - 1) { echo ", "; }
    $i++;
}
?>