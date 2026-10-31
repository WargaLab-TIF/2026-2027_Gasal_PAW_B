<?php
function tampil($arr) {
    foreach ($arr as $kunci => $nilai) {
        echo $kunci . '=> ' . $nilai . ', ';
    }
    echo '<br>';
}

$a = array('A');
echo 'Array awal: ("A")<br>';
array_push($a, 'B');
echo 'Hasil array_push: ' . implode(' ', $a) . '<br><br>';

echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
echo 'Hasil array_merge: ' . implode(' ', array_merge(array('A', 'B'), array('C'))) . '<br><br>';

echo 'Array awal: ("x" => 1, "y" => 2)<br>';
echo 'Hasil array_values: ' . implode(' ', array_values(array('x' => 1, 'y' => 2))) . '<br><br>';

echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
echo 'Hasil array_search: ' . array_search('B', array('A', 'B', 'C')) . '<br><br>';

echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
echo 'Hasil array_filter: ' . implode(' ', array_filter(array(0, 1, false, 2, '', 3, 'array'))) . '<br><br>';

$n = array(3, 1, 2);
echo 'Array awal: (3, 1, 2)<br>';
sort($n);
echo 'Hasil sort: ' . implode(' ', $n) . '<br>';
rsort($n);
echo 'Hasil rsort: ' . implode(' ', $n) . '<br><br>';

$u = array('Peter' => 35, 'Ben' => 37, 'Joe' => 43);
echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';
asort($u);
echo 'Hasil asort: ';
tampil($u);
ksort($u);
echo 'Hasil ksort: ';
tampil($u);
arsort($u);
echo 'Hasil arsort: ';
tampil($u);
krsort($u);
echo 'Hasil krsort: ';
tampil($u);