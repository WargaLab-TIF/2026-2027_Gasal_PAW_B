<?php
$huruf = array("A");
echo 'Array awal: ("A")<br>';
array_push($huruf,"B");
echo "Hasil array_push: ";
foreach($huruf as $value) {
    echo $value;
}
echo "<br><br>";

$huruf1 = array("A","B");
$huruf2 = array("C");
echo 'Array awal: ("A","B") digabung dengan ("C")<br>';
$gabung = array_merge($huruf1,$huruf2);
echo "Hasil array_merge: ";
foreach($gabung as $value) {
    echo $value;
}
echo "<br><br>";

$data = array("x"=>1,"y"=>2);
echo 'Array awal: ("x"=>1,"y"=>2)<br>';
$hasil = array_values($data);
echo "Hasil array_values: ";
foreach($hasil as $value) {
    echo $value;
}
echo "<br><br>";

$huruf = array("A","B","C");
echo 'Mencari "B" pada array: ("A","B","C")<br>';
echo "Hasil array_search: ".array_search("B",$huruf);
echo "<br><br>";

$data = array(0,1,false,2,"",3,"array");
echo 'Array awal: (0,1,false,2,"",3,"array")<br>';
$hasil = array_filter($data);
echo "Hasil array_filter: ";
foreach($hasil as $value) {
    echo $value." ";
}
echo "<br><br>";

$angka = array(3,1,2);
echo "Array awal: (3,1,2)<br>";

sort($angka);
echo "Hasil sort: ";
foreach($angka as $value) {
    echo $value." ";
}
echo "<br>";

rsort($angka);
echo "Hasil rsort: ";
foreach($angka as $value) {
    echo $value." ";
}
echo "<br><br>";

$umur = array("Peter"=>35,"Ben"=>37,"Joe"=>43);
echo 'Array awal: ("Peter"=>35,"Ben"=>37,"Joe"=>43)<br>';

asort($umur);
echo "Hasil asort: ";
foreach($umur as $key => $value) {
    echo $key."=>".$value." ";
}
echo "<br>";

ksort($umur);
echo "Hasil ksort: ";
foreach($umur as $key => $value) {
    echo $key."=>".$value." ";
}
echo "<br>";

arsort($umur);
echo "Hasil arsort: ";
foreach($umur as $key => $value) {
    echo $key."=>".$value." ";
}
echo "<br>";

krsort($umur);
echo "Hasil krsort: ";
foreach($umur as $key => $value) {
    echo $key."=>".$value." ";
}
?>
