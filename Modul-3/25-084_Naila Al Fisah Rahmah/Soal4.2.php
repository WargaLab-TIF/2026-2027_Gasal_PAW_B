<?php
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");

echo 'weight = ("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75")<br><br>';

$nama = array("Andy", "Barry", "Charlie");

for ($i = 0; $i < count($weight); $i++) {
    echo $nama[$i] . " is " . $weight[$nama[$i]] . " kg.<br>";
}
?>