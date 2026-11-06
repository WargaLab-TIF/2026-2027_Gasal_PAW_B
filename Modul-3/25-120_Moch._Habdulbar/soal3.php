<?php
$height = array(
	"Andy"=>"176",
	"Barry"=>"165",
	"Charlie"=>"170"
);

echo "Andy is " . $height['Andy'] ." cm tall. <br><br>";

//3.1
$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

echo "height= ";
foreach ($height as $nama => $tinggi) {
echo $nama . ' => ' . $tinggi . ', ';
}
echo "<br> Nilai dengan indeks terakhir= ". max($height);


unset($height["Barry"]);

echo "<br><br>height= ";
foreach ($height as $nama => $tinggi) {
echo $nama . ' => ' . $tinggi . ', ';
}
echo "<br> Nilai dengan indeks terakhir setelah dihapus= ". max($height);


//3.2
$weight = array(
	"Andy"=>"70",
	"Barry"=>"65",
	"Charlie"=>"75"
);
echo "<br><br>weight= (";
foreach ($weight as $nama => $berat) {
echo $nama . ' => ' . $berat . ', ';
}
echo ")";
echo "<br>Data kedua: ". $weight["Barry"];

?>