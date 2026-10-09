<?php
$a = array('A');
echo 'Array awal: ("A")<br>';
array_push($a, 'B');
echo 'Hasil array_push: ';
foreach ($a as $nilai) {
    echo $nilai . ' ';
}
echo '<br><br>';

$b1 = array('A', 'B');
$b2 = array('C');
$b = array_merge($b1, $b2);
echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
echo 'Hasil array_merge: ';
foreach ($b as $nilai) {
    echo $nilai . ' ';
}
echo '<br><br>';

$c = array('x' => 1, 'y' => 2);
$c = array_values($c);
echo 'Array awal: ("x" => 1, "y" => 2)<br>';
echo 'Hasil array_values: ';
foreach ($c as $nilai) {
    echo $nilai . ' ';
}
echo '<br><br>';

$d = array('A', 'B', 'C');
echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
echo 'Hasil array_search: ' . array_search('B', $d) . '<br><br>';

$e = array(0, 1, false, 2, '', 3, 'array');
$e = array_filter($e);
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
echo 'Hasil array_filter: ';
foreach ($e as $nilai) {
    echo $nilai . ' ';
}
echo '<br><br>';

$f = array(3, 1, 2);
echo 'Array awal: (3, 1, 2)<br>';
sort($f);
echo 'Hasil sort: ';
foreach ($f as $nilai) {
    echo $nilai . ' ';
}
echo '<br>';
rsort($f);
echo 'Hasil rsort: ';
foreach ($f as $nilai) {
    echo $nilai . ' ';
}
echo '<br><br>';

echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

$umur = array('Peter' => 35, 'Ben' => 37, 'Joe' => 43);
asort($umur);
echo 'Hasil asort: ';
foreach ($umur as $nama => $usia) {
    echo $nama . '=> ' . $usia . ', ';
}
echo '<br>';

$umur = array('Peter' => 35, 'Ben' => 37, 'Joe' => 43);
ksort($umur);
echo 'Hasil ksort: ';
foreach ($umur as $nama => $usia) {
    echo $nama . '=> ' . $usia . ', ';
}
echo '<br>';

$umur = array('Peter' => 35, 'Ben' => 37, 'Joe' => 43);
arsort($umur);
echo 'Hasil arsort: ';
foreach ($umur as $nama => $usia) {
    echo $nama . '=> ' . $usia . ', ';
}
echo '<br>';

$umur = array('Peter' => 35, 'Ben' => 37, 'Joe' => 43);
krsort($umur);
echo 'Hasil krsort: ';
foreach ($umur as $nama => $usia) {
    echo $nama . '=> ' . $usia . ', ';
}
echo '<br>';
?>
