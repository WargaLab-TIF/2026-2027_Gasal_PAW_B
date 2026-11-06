<?php
$array = array("A");
echo 'Array awal: ("A")<br>';
array_push($array, "B");

echo "Hasil array_push: ";
foreach ($array as $data) {
    echo $data." ";
}
echo "<br><br>";


$array1 = array("A", "B");
$array2 = array("C");
echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
$hasil = array_merge($array1, $array2);

echo "Hasil array_merge: ";
foreach ($hasil as $data) {
    echo $data." ";
}
echo "<br><br>";


$array = array("x" => 1, "y" => 2);
echo 'Array awal: ("x" => 1, "y" => 2)<br>';
$hasil = array_values($array);
echo "Hasil array_values: ";
foreach ($hasil as $data) {
    echo $data." ";
}
echo "<br><br>";

$array = array("A", "B", "C");
echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
$hasil = array_search("B", $array);

echo "Hasil array_search: ".$hasil;
echo "<br><br>";

$array = array(0, 1, false, 2, "", 3, "array");
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
$hasil = array_filter($array);
echo "Hasil array_filter: ";
foreach ($hasil as $data) {
    echo $data." ";
}
echo "<br><br>";


$array = array(3, 1, 2);
echo "Array awal: (3, 1, 2)<br>";
sort($array);
echo "Hasil sort: ";
foreach ($array as $data) {
    echo $data." ";
}

$array = array(3, 1, 2);
rsort($array);
echo "<br>Hasil rsort: ";
foreach ($array as $data) {
    echo $data." ";
}
echo "<br><br>";

$array = array("Peter" => 35, "Ben" => 37, "Joe" => 43);

echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';
$data = $array;
asort($data);
echo "Hasil asort: ";
foreach ($data as $nama => $umur) {
    echo $nama."=> ".$umur.", ";
}

$data = $array;
ksort($data);

echo "<br>Hasil ksort: ";
foreach ($data as $nama => $umur) {
    echo $nama."=> ".$umur.", ";
}

$data = $array;
arsort($data);
echo "<br>Hasil arsort: ";
foreach ($data as $nama => $umur) {
    echo $nama."=> ".$umur.", ";
}

$data = $array;
krsort($data);

echo "<br>Hasil krsort: ";
foreach ($data as $nama => $umur) {
    echo $nama."=> ".$umur.", ";
}
?>