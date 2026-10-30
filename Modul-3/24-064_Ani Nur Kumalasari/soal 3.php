<?php
$height = array("Andy"=>"176","Barry"=>"165","Charlie"=>"170");
$height["david"]="180";
$height["ethan"]="172";
$height["frank"]="168";
$height["george"]="175";
$height["harry"]="182";

echo "height =";
foreach ($height as $nama => $tinggi) {
	echo '"' . $nama . '"=>"' . $tinggi . '"'; 
	if ($nama != "harry") { 
		echo ", "; } 
}
echo ")";
echo "<br>Nilai dengan indeks terakhir: "; 
echo end($height);

unset($height["Barry"]);
echo"<br>";

foreach ($height as $nama => $tinggi) { 
	echo '"' . $nama . '"=>"' . $tinggi . '"'; 
	if ($nama != "harry") { 
		echo ", "; }
 }

echo ")"; 
echo "<br>Nilai dengan indeks terakhir setelah dihapus: "; 
echo end($height); 