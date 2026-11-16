<?php
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");

$height["Dandi"] = "182";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Ham"] = "182";

echo 'height = ("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170", "Dandi"=>"182", "Ethan"=>"172", "Frank"=>"168", "George"=>"175", "Ham"=>"182")<br>';

echo "Nilai dengan indeks terakhir: " . end($height) . "<br>";
echo "<br>";
unset($height["Andy"]);

echo 'height = ("Barry"=>"165", "Charlie"=>"170", "Dandi"=>"182", "Ethan"=>"172", "Frank"=>"168", "George"=>"175", "Ham"=>"182")<br>';

echo "Nilai dengan indeks terakhir: " . end($height);
?>