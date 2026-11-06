<?php
$a = array("A");
echo "Array awal: (\"" . implode('", "', $a) . "\")<br>";

array_push($a, "B");
echo "Hasil array_push: " . implode(" ", $a) . "<br><br>";

$a = array("A", "B");
$b = array("C");

echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
$c = array_merge($a, $b);
echo "Hasil array_merge: " . implode(" ", $c) . "<br><br>";

$a = array("x" => 1, "y" => 2);
echo 'Array awal: ("x" => 1, "y" => 2)<br>';

$b = array_values($a);
echo "Hasil array_values: " . implode(" ", $b) . "<br><br>";

$a = array("A", "B", "C");
echo 'Mencari "B" pada array: ("A", "B", "C")<br>';

$hasil = array_search("B", $a);
echo "Hasil array_search: " . $hasil . "<br><br>";

$a = array(0, 1, false, 2, "", 3, "array");
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';

$b = array_filter($a);
echo "Hasil array_filter: " . implode(" ", $b) . "<br><br>";

$a = array(3, 1, 2);
echo "Array awal: (3, 1, 2)<br>";

$b = $a;
sort($b);
echo "Hasil sort: " . implode(" ", $b) . "<br>";

$b = $a;
rsort($b);
echo "Hasil rsort: " . implode(" ", $b) . "<br><br>";

$a = array("Peter" => 35, "Ben" => 37, "Joe" => 43);
echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

$b = $a;
asort($b);
echo "Hasil asort: ";
foreach ($b as $nama => $umur) {
    echo "$nama => $umur, ";
}
echo "<br>";

$b = $a;
arsort($b);
echo "Hasil arsort: ";
foreach ($b as $nama => $umur) {
    echo "$nama => $umur, ";
}
echo "<br>";

$b = $a;
ksort($b);
echo "Hasil ksort: ";
foreach ($b as $nama => $umur) {
    echo "$nama => $umur, ";
}
echo "<br>";

$b = $a;
krsort($b);
echo "Hasil krsort: ";
foreach ($b as $nama => $umur) {
    echo "$nama => $umur, ";
}
?>