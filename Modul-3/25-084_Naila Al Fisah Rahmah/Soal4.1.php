<?php
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");

$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";
$height["Harry"] = "170";

echo 'height = ("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170", "David"=>"180", "Ethan"=>"172", "Frank"=>"168", "George"=>"175", "Harry"=>"182")<br><br>';

foreach ($height as $nama => $tinggi) {
    echo "$nama is $tinggi cm tall.<br>";
}
?>