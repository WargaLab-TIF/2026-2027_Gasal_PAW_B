<?php 	 
$height = array("Andy"=>"176", "Barry"=> "165", "Charlie"=> "170");
$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

$out = array();
foreach($height as $key => $val) {
    $out[] = '"' . $key . '"=>"' . $val . '"';
}
echo 'height = (' . implode(', ', $out) . ')<br><br>';
foreach ($height as $nama => $tinggi) {
    echo $nama . " is " . $tinggi . " cm tall.<br>";
}
?>