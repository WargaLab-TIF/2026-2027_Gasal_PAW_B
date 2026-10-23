<?php

$height = array("Andy"=>"176",
	"Barry"=>"165",
	"Charlie"=>"170"
);

//4.1
$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

echo "height= (";
foreach ($height as $nama => $tinggi) {
  echo $nama . "=>" . $tinggi . ", ";
}
echo ")<br><br>";
 
foreach ($height as $nama => $tinggi) {
  echo $nama . " is " . $tinggi . " cm tall.<br>";
}

//4.2
$weight = array("Andy"=>"70","Barry"=>"65","Charlie"=>"75");
 
echo "<br>weight= (";
foreach ($weight as $nama => $berat) {
  echo $nama . "=>" . $berat . ", ";
}
echo ")<br><br>";

foreach ($weight as $nama => $berat) {
  echo $nama . " is " . $berat . " Kg.<br>";
}

?>