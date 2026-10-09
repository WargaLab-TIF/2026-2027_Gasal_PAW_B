
<?php
$weight = array("Andy"=>"70","Barry"=>"65","Charlie"=>"75");
$nama =array_keys($weight);
$data = array_values($weight);
$arrlength = count($data);
echo "weight = (";
foreach ($weight as $key => $value) {
	echo $key."=>".$value. " ";
};
echo")<br><br>";
for($x = 0; $x < $arrlength; $x++) {
    echo $nama[$x]." is ".$data[$x]." Kg<br>";
}
?>
