<?php

$arr1 = array("A");
echo 'Array awal: ("A")<br>';
array_push($arr1, "B");
echo 'Hasil array_push: ' . implode(" ", $arr1) . '<br><br>';

$arr2_a = array("A", "B");
$arr2_b = array("C");
echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
$arr2_merged = array_merge($arr2_a, $arr2_b);
echo 'Hasil array_merge: ' . implode(" ", $arr2_merged) . '<br><br>';

$arr3 = array("x"=>1, "y"=>2);
echo 'Array awal: ("x"=>1, "y"=>2)<br>';
$arr3_values = array_values($arr3);
echo 'Hasil array_values: ' . implode(" ", $arr3_values) . '<br><br>';

$arr4 = array("A", "B", "C");
echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
$index = array_search("B", $arr4);
echo 'Hasil array_search: ' . $index . '<br><br>';

// 5. array_filter()
$arr5 = array(0, 1, false, 2, "", 3, "array");
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
$arr5_filtered = array_filter($arr5);
echo 'Hasil array_filter: ' . implode(" ", $arr5_filtered) . '<br><br>';

// 6. Sorting Array Terindeks (sort & rsort)
$arr6 = array(3, 1, 2);
echo 'Array awal: (3, 1, 2)<br>';
$arr6_sort = $arr6; 
sort($arr6_sort);
echo 'Hasil sort: ' . implode(" ", $arr6_sort) . '<br>';

$arr6_rsort = $arr6; 
rsort($arr6_rsort);
echo 'Hasil rsort: ' . implode(" ", $arr6_rsort) . '<br><br>';

// 7. Sorting Array Asosiatif (asort, ksort, arsort, krsort)
$arr7 = array("Peter"=>35, "Ben"=>37, "Joe"=>43);
echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

// Fungsi bantuan untuk mencetak array asosiatif sesuai format soal
function cetak_asosiatif($arr) {
    $str = "";
    foreach($arr as $k => $v) {
        $str .= $k . "=>" . $v . ", ";
    }
    return $str;
}

$arr7_asort = $arr7; 
asort($arr7_asort);
echo 'Hasil asort: ' . cetak_asosiatif($arr7_asort) . '<br>';

$arr7_ksort = $arr7; 
ksort($arr7_ksort);
echo 'Hasil ksort: ' . cetak_asosiatif($arr7_ksort) . '<br>';

$arr7_arsort = $arr7; 
arsort($arr7_arsort);
echo 'Hasil arsort: ' . cetak_asosiatif($arr7_arsort) . '<br>';

$arr7_krsort = $arr7; 
krsort($arr7_krsort);
echo 'Hasil krsort: ' . cetak_asosiatif($arr7_krsort) . '<br>';

?>