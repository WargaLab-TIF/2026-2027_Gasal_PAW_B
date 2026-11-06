<?php
echo 'Array awal: ("A")<br>';

$array = array("A");
array_push($array, "B");

echo 'Hasil array_push: ';

$arrlength = count($array);

for ($x = 0; $x < $arrlength; $x++) {
    echo $array[$x] . " ";
}

echo '<br><br>';


echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';

$array1 = array("A", "B");
$array2 = array("C");

$hasil = array_merge($array1, $array2);

echo 'Hasil array_merge: ';

$arrlength = count($hasil);

for ($x = 0; $x < $arrlength; $x++) {
    echo $hasil[$x] . " ";
}

echo '<br><br>';


echo 'Array awal: ("x" => 1, "y" => 2)<br>';

$array = array("x" => 1, "y" => 2);
$hasil = array_values($array);

echo 'Hasil array_values: ';

$arrlength = count($hasil);

for ($x = 0; $x < $arrlength; $x++) {
    echo $hasil[$x] . " ";
}

echo '<br><br>';


echo 'Mencari "B" pada array: ("A", "B", "C")<br>';

$array = array("A", "B", "C");
$hasil = array_search("B", $array);

echo 'Hasil array_search: ' . $hasil;

echo '<br><br>';


echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';

$array = array(0, 1, false, 2, "", 3, "array");

$hasil = array_filter($array, function ($nilai) {
    return is_numeric($nilai) && $nilai != 0;
});

echo 'Hasil array_filter: ';

foreach ($hasil as $nilai) {
    echo $nilai . " ";
}

echo '<br><br>';


echo 'Array awal: (3, 1, 2)<br>';

$array = array(3, 1, 2);

sort($array);

echo 'Hasil sort: ';

$arrlength = count($array);

for ($x = 0; $x < $arrlength; $x++) {
    echo $array[$x] . " ";
}

rsort($array);

echo '<br>Hasil rsort: ';

$arrlength = count($array);

for ($x = 0; $x < $arrlength; $x++) {
    echo $array[$x] . " ";
}

echo '<br><br>';


echo 'Array awal: ("Peter" => 35, "Ben" => 37, "Joe" => 43)<br>';

$array = array(
    "Peter" => 35,
    "Ben" => 37,
    "Joe" => 43
);

asort($array);

echo 'Hasil asort: ';

foreach ($array as $nama => $umur) {
    echo $nama . " => " . $umur . ", ";
}

arsort($array);

echo '<br>Hasil arsort: ';

foreach ($array as $nama => $umur) {
    echo $nama . " => " . $umur . ", ";
}

ksort($array);

echo '<br>Hasil ksort: ';

foreach ($array as $nama => $umur) {
    echo $nama . " => " . $umur . ", ";
}

krsort($array);

echo '<br>Hasil krsort: ';

foreach ($array as $nama => $umur) {
    echo $nama . " => " . $umur . ", ";
}
?>