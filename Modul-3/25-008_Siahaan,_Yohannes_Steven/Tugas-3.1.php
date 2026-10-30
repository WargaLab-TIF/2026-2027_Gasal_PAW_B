<?php
$height = array("Andy"=>"176","Barry"=>"165","Charlie"=>"170");
$height2 = array("David" => "180", "Ethan" => "172", "Frank" => "168", "George" => "175", "Harry" => "182");

$final_height = array_merge($height, $height2);

foreach ($final_height as $key => $value) {
}

print_r($final_height);
echo "<br>";
echo "Nilai dengan indeks terakhir: " .$value. "<br><br>";

unset($final_height["Barry"]);
print_r($final_height);
echo "<br>";
echo "Nilai dengan indeks terakhir: " .$value. "<br><br>";
?>