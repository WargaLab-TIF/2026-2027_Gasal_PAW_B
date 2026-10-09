<?php
// array_push
$array1 = ["A"];
echo 'Array awal: ("A")<br>';

array_push($array1, "B");

echo "Hasil array_push: (";
foreach ($array1 as $v) {
    echo $v . " ";
}
echo ")<br><br>";

// array_merge
$array2 = ["A", "B"];
$array3 = ["C"];
echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';

$hasilMerge = array_merge($array2, $array3);
echo "Hasil array_merge: (";
foreach ($hasilMerge as $v) {
    echo $v . " ";
}
echo ")<br><br>";

// array_values
$array4 = ["x" => 1, "y" => 2];
echo 'Array awal: ("x"=>1, "y"=>2)<br>';

echo "Hasil array_values: (";
foreach (array_values($array4) as $v) {
    echo $v . " ";
}
echo ")<br><br>";

// array_search
$array5 = ["A", "B", "C"];
echo 'Mencari "B" pada array: ("A", "B", "C")<br>';

echo "Hasil array_search: (" . array_search("B", $array5) . ")<br><br>";

// array_filter
$array6 = [0, 1, false, 2, "", 3, "array"];
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';

echo "Hasil array_filter: (";
foreach (array_filter($array6) as $v) {
    echo $v . " ";
}
echo ")<br><br>";


// sort dan rsort
$array7 = [3, 1, 2];
echo "Array awal: (3, 1, 2)<br>";

$urutNaik = $array7;
sort($urutNaik);
echo "Hasil sort: (";
foreach ($urutNaik as $v) {
    echo $v . " ";
}
echo ")<br>";

$urutTurun = $array7;
rsort($urutTurun);

echo "Hasil rsort: (";
foreach ($urutTurun as $v) {
    echo $v . " ";
}
echo ")<br><br>";


// asort, arsort, ksort, dan krsort
$array8 = ["Peter" => 35, "Ben" => 37, "Joe" => 43];
echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

$hasilAsort = $array8;
asort($hasilAsort);

echo "Hasil asort: (";
foreach ($hasilAsort as $k => $v) {
    echo "$k=>$v ";
}
echo ")<br>";

$hasilArsort = $array8;
arsort($hasilArsort);

echo "Hasil arsort: (";
foreach ($hasilArsort as $k => $v) {
    echo "$k=>$v ";
}
echo ")<br>";

$hasilKsort = $array8;
ksort($hasilKsort);

echo "Hasil ksort: (";
foreach ($hasilKsort as $k => $v) {
    echo "$k=>$v ";
}
echo ")<br>";

$hasilKrsort = $array8;
krsort($hasilKrsort);

echo "Hasil krsort: (";
foreach ($hasilKrsort as $k => $v) {
    echo "$k=>$v ";
}
echo ")<br>";
?>