
<?php
$height = array("Andy" => "176","Barry" => "165","Charlie" => "170");

$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

echo 'height = ';

foreach ($height as $key => $value) {
    echo "$key => $value ";
}

echo "<br>Nilai dengan indeks terakhir: " . $value . "<br><br>";
	
unset($height["Barry"]);

echo 'height = ';

foreach ($height as $key => $value) {
    echo "$key => $value ";
}


echo "<br>Nilai dengan indeks terakhir setelah dihapus: " . $value;
?>