<?php
$height=array("Andy"=>"176","Barry"=>"165","Charlie"=>"170");

$height["David"] = "180";
$height["Ethan"] = "172";
$height["Frank"] = "168";
$height["George"] = "175";
$height["Harry"] = "182";

echo 'height = (';
foreach ($height as $nama => $nilai) {
    echo '"' . $nama . '"=>"' . $nilai . '"';
}
echo ')';
echo '<br>nilai dari indeks terakhir: '. end($height);
echo "<br>";
echo "<br>";

unset($height["Barry"]);

echo 'height = (';
foreach ($height as $nama => $nilai) {
	echo '"' . $nama . '"=>"' . $nilai . '"';
	}
echo ')';
echo '<br>nilai dari indeks terakhir: '. end($height);

echo "<br>";
echo "<br>";
$weight = array("Andy"=>"70","Barry"=>"65","Charlie"=>"75");
echo 'weight = (';
foreach ($weight as $nama => $nilai) {
	echo '"' . $nama . '"=>"' . $nilai . '"';
	}
echo ')';
echo "<br>Data kedua; ".$weight["Barry"];
?>
