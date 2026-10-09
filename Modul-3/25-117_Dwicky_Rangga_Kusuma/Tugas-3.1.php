<?php
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");
$height["David"]="180";
$height["Ethan"]="172";
$height["Frank"]="168";
$height["George"]="175";
$height["Harry"]="182";
echo "height = ";
print_r($height);
$terakhir = end($height);
echo "<br>Nilai dengan indeks terakhir: $terakhir <br><br>";
unset($height["Barry"]);
echo "height = ";
print_r($height);
$terakhir = end($height);
echo "<br>Nilai dengan indeks terakhir setelah dihapus: $terakhir";
?>