<?php
// 6.1 Implementasi fungsi array

// 1. array_push()
$arr1 = array("A");
echo "Array awal: (\"A\")<br>";
array_push($arr1, "B");
echo "Hasil array_push: " . implode(" ", $arr1) . "<br><br>";

// 2. array_merge()
$arr2a = array("A", "B");
$arr2b = array("C");
echo "Array awal: (\"A\", \"B\") digabung dengan (\"C\")<br>";
$merged = array_merge($arr2a, $arr2b);

// 3. array_values()
$arr3 = array("x" => 1, "y" => 2);
echo "Array awal: (\"x\" => 1, \"y\" => 2)<br>";
$values = array_values($arr3);
echo "Hasil array_values: " . implode(" ", $values) . "<br><br>";

// 4. array_search()
$arr4 = array("A", "B", "C");
echo "Mencari \"B\" pada array: (\"A\", \"B\", \"C\")<br>";
$posisi = array_search("B", $arr4);
echo "Hasil array_search: " . $posisi . "<br><br>";

// 5. array_filter()
$arr5 = array(0, 1, false, 2, "", 3, "array");
echo "Array awal: (0, 1, false, 2, \"\", 3, \"array\")<br>";
$filtered = array_filter($arr5);
echo "Hasil array_filter: " . implode(" ", $filtered) . "<br><br>";

// 6. Fungsi Sorting
$arr6 = array(3, 1, 2);
echo "Array awal: (3, 1, 2)<br>";
sort($arr6);
echo "Hasil sort: " . implode(" ", $arr6) . "<br>";
rsort($arr6);
echo "Hasil rsort: " . implode(" ", $arr6) . "<br><br>";

// asort, ksort, arsort, krsort (array asosiatif)
$arr7 = array("Peter" => 35, "Ben" => 37, "Joe" => 43);
echo "Array awal: (\"Peter\"=>35, \"Ben\"=>37, \"Joe\"=>43)<br>";

asort($arr7);
echo "Hasil asort: ";
foreach ($arr7 as $k => $v) {
    echo $k . " => " . $v . ", ";
}
echo "<br>";

ksort($arr7);
echo "Hasil ksort: ";
foreach ($arr7 as $k => $v) {
    echo $k . " => " . $v . ", ";
}
echo "<br>";

arsort($arr7);
echo "Hasil arsort: ";
foreach ($arr7 as $k => $v) {
    echo $k . " => " . $v . ", ";
}
echo "<br>";

krsort($arr7);
echo "Hasil krsort: ";
foreach ($arr7 as $k => $v) {
    echo $k . " => " . $v . ", ";
}
echo "<br>";
?>