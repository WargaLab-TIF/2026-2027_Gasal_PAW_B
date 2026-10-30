<?php
$data = array("A");

echo 'Array awal: ("A")<br>';

array_push($data, "B");

echo "Hasil array_push: ";
foreach ($data as $nilai) {
    echo "$nilai ";
}

echo "<br><br>";


$data1 = array("A", "B");
$data2 = array("C");

echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';

$hasil = array_merge($data1, $data2);

echo "Hasil array_merge: ";
foreach ($hasil as $nilai) {
    echo "$nilai ";
}

echo "<br><br>";


$data = array("x" => 1, "y" => 2);

echo 'Array awal: ("x" => 1, "y" => 2)<br>';

$hasil = array_values($data);

echo "Hasil array_values: ";
foreach ($hasil as $nilai) {
    echo "$nilai ";
}

echo "<br><br>";


$data = array("A", "B", "C");

echo 'Mencari "B" pada array: ("A", "B", "C")<br>';

$hasil = array_search("B", $data);

echo "Hasil array_search: " . $hasil;
echo "<br><br>";


$data = array(0, 1, false, 2, "", 3, "array");

echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';

$hasil = array_filter($data);

echo "Hasil array_filter: ";
foreach ($hasil as $nilai) {
    echo "$nilai ";
}

echo "<br><br>";


$angka = array(3, 1, 2);

echo "Array awal: (3, 1, 2)<br>";

sort($angka);

echo "Hasil sort: ";
foreach ($angka as $nilai) {
    echo "$nilai ";
}

rsort($angka);

echo "<br>Hasil rsort: ";
foreach ($angka as $nilai) {
    echo "$nilai ";
}

echo "<br><br>";


$umur = array("Peter" => 35, "Ben" => 37, "Joe" => 43);

echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

asort($umur);

echo "Hasil asort: ";
foreach ($umur as $nama => $nilai) {
    echo "$nama => $nilai, ";
}

ksort($umur);

echo "<br>Hasil ksort: ";
foreach ($umur as $nama => $nilai) {
    echo "$nama => $nilai, ";
}

arsort($umur);

echo "<br>Hasil arsort: ";
foreach ($umur as $nama => $nilai) {
    echo "$nama => $nilai, ";
}

krsort($umur);

echo "<br>Hasil krsort: ";
foreach ($umur as $nama => $nilai) {
    echo "$nama => $nilai, ";
}
?>