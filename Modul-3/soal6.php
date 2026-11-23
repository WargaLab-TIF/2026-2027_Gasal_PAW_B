<?php
function tampil($arr) {
    echo implode(" ", $arr) . "<br>";
}

function tampilAsosiatif($arr) {
    foreach ($arr as $k => $v) {
        echo "$k=> $v, ";
    }
    echo "<br>";
}

// 1. array_push()
$a = ["A"];
echo 'Array awal: ("A")<br>';
array_push($a, "B");
echo "Hasil array_push: "; tampil($a);
echo "<br>";

// 2. array_merge()
$a1 = ["A", "B"];
$a2 = ["C"];
echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
echo "Hasil array_merge: "; tampil(array_merge($a1, $a2));
echo "<br>";

// 3. array_values()
$b = ["x" => 1, "y" => 2];
echo 'Array awal: ("x" => 1, "y" => 2)<br>';
echo "Hasil array_values: "; tampil(array_values($b));
echo "<br>";

// 4. array_search()
$c = ["A", "B", "C"];
echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
echo "Hasil array_search: " . array_search("B", $c) . "<br><br>";

// 5. array_filter() -> membuang nilai kosong (0, false, "")
$d = [0, 1, false, 2, "", 3, "array"];
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
echo "Hasil array_filter: "; tampil(array_filter($d));
echo "<br>";

// 6. sort() dan rsort() untuk array indeks
$e = [3, 1, 2];
echo "Array awal: (3, 1, 2)<br>";
sort($e);
echo "Hasil sort: "; tampil($e);
rsort($e);
echo "Hasil rsort: "; tampil($e);
echo "<br>";

// 7. asort(), ksort(), arsort(), krsort() untuk array asosiatif
$umur = ["Peter" => 35, "Ben" => 37, "Joe" => 43];
echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

$t = $umur; asort($t);
echo "Hasil asort: ";  tampilAsosiatif($t);   

$t = $umur; ksort($t);
echo "Hasil ksort: ";  tampilAsosiatif($t);   

$t = $umur; arsort($t);
echo "Hasil arsort: "; tampilAsosiatif($t);   

$t = $umur; krsort($t);
echo "Hasil krsort: "; tampilAsosiatif($t);   
?>