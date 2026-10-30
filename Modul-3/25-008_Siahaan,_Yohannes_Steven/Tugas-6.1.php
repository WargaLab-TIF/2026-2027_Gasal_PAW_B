<?php
$arr_push = array("A");count($arr_push);
echo "Array awal: (";
for ($i=0; $i < count($arr_push); $i++) { 
	echo " ".$arr_push[$i];
}
echo ")<br>";

array_push($arr_push, "B");
echo "Hasil array_push: ";
for ($i=0; $i < count($arr_push); $i++) { 
	echo " ".$arr_push[$i];
}

echo "<br><br>";
$arr_merge1 = array("A", "B");
$arr_merge2 = array("C");
$arr_merge3 = array_merge($arr_merge1, $arr_merge2);

echo "Array awal: (";
for ($i=0; $i < count($arr_merge1); $i++) { 
	echo " ".$arr_merge1[$i];
}
echo ") digabung dengan (";
for ($i=0; $i < count($arr_merge2); $i++) { 
	echo " ".$arr_merge2[$i];
}
echo ")<br>";
echo "Hasil array_merge: ";
for ($i=0; $i < count($arr_merge3); $i++) { 
	echo " ".$arr_merge3[$i];
}
echo "<br><br>";

$arr_values = array("x" => 1, "y" => 2);
$hasil_values = array_values($arr_values);
echo "Array awal: (";
foreach ($arr_values as $key => $value) { 
	echo $key. "=>" .$value ;
}
echo ")<br>";
echo "Hasil array_values: ";
for ($i=0; $i < count($hasil_values); $i++) { 
	echo " ".$hasil_values[$i];
}
echo "<br><br>";

$arr_search = array("A", "B", "C");
$hasil_search = array_search("B", $arr_search);
echo 'Mencari "B" pada array: (';
for ($i=0; $i < count($arr_search); $i++) { 
	echo " ".$arr_search[$i];
}
echo ")<br> Hasil array_search: " .$hasil_search. "<br><br>";

$a = array(0, 1, false, 2, 3, "array");
$b = array_filter($a);

echo "Array awal: 0, 1, false, 2, 3, array<br>";
echo "Hasil array_filter: ";
foreach ($b as $value) {
    echo $value . " ";
}
echo "<br><br>";

$a = array(3, 1, 2);
echo "Array awal: ";
print_r($a);
sort($a);

echo "Hasil sort: ";
foreach ($a as $value) {
    echo $value . " ";
}
echo "<br>";

$a = array(3, 1, 2);
rsort($a);

echo "Hasil rsort: ";
foreach ($a as $value) {
    echo $value . " ";
}
echo "<br><br>";

$a = array("Peter" => 365, "Ben" => 37, "Joe" => 43);
echo "Array awal: ";
print_r($a);
asort($a);

echo "<br>";
echo "Hasil asort: ";
foreach ($a as $name => $value) {
    echo $name . " => " . $value . ", ";
}
echo "<br>";

$a = array("Peter" => 365, "Ben" => 37, "Joe" => 43);
ksort($a);

echo "Hasil ksort: ";
foreach ($a as $name => $value) {
    echo $name . " => " . $value . ", ";
}
echo "<br>";

$a = array("Peter" => 365, "Ben" => 37, "Joe" => 43);
arsort($a);

echo "Hasil arsort: ";
foreach ($a as $name => $value) {
    echo $name . " => " . $value . ", ";
}
echo "<br>";

$a = array("Peter" => 365, "Ben" => 37, "Joe" => 43);
krsort($a);

echo "Hasil krsort: ";
foreach ($a as $name => $value) {
    echo $name . " => " . $value . ", ";
}
?>