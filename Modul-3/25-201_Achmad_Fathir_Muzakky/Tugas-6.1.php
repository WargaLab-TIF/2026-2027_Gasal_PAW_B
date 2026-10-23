<?php
$a = array("A");
array_push($a, "B");

echo "Array awal: A<br>";
echo "Hasil array_push: ";
for ($i = 0; $i < count($a); $i++) {
    echo $a[$i];
}
echo "<br><br>";

$a = array("A", "B");
$b = array("C");
$c = array_merge($a, $b);

echo "Array awal: A, B digabung dengan C<br>";
echo "Hasil array_merge: ";
for ($i = 0; $i < count($c); $i++) {
    echo $c[$i] . " ";
}
echo "<br><br>";

$a = array("x" => 1, "y" => 2);
$b = array_values($a);

echo "Array awal: x = 1, y = 2<br>";
echo "Hasil array_values: ";
for ($i = 0; $i < count($b); $i++) {
    echo $b[$i] . " ";
}
echo "<br><br>";

$a = array("A", "B", "C");

echo "Mencari B pada array A, B, C<br>";
echo "Hasil array_search: " . array_search("B", $a);
echo "<br><br>";

$a = array(0, 1, false, 2, 3, "array");
$b = array_filter($a);

echo "Array awal: 0, 1, false, 2, 3, array<br>";
echo "Hasil array_filter: ";
foreach ($b as $value) {
    echo $value . " ";
}
echo "<br><br>";

$a = array(3, 1, 2);
sort($a);

echo "Hasil sort: ";
foreach ($a as $value) {
    echo $value . " ";
}
echo "<br>";

$a = array(3, 1, 2);
rsort($a);

echo "Hasil rsort: ";
foreach ($a as $value) {
    echo $value . " ";
}
echo "<br><br>";

$a = array("Peter" => 365, "Ben" => 37, "Joe" => 43);
asort($a);

echo "Hasil asort: ";
foreach ($a as $name => $value) {
    echo $name . " => " . $value . ", ";
}
echo "<br>";

$a = array("Peter" => 365, "Ben" => 37, "Joe" => 43);
ksort($a);

echo "Hasil ksort: ";
foreach ($a as $name => $value) {
    echo $name . " => " . $value . ", ";
}
echo "<br>";

$a = array("Peter" => 365, "Ben" => 37, "Joe" => 43);
arsort($a);

echo "Hasil arsort: ";
foreach ($a as $name => $value) {
    echo $name . " => " . $value . ", ";
}
echo "<br>";

$a = array("Peter" => 365, "Ben" => 37, "Joe" => 43);
krsort($a);

echo "Hasil krsort: ";
foreach ($a as $name => $value) {
    echo $name . " => " . $value . ", ";
}

?>