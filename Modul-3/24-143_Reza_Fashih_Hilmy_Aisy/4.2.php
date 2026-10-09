<?php
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");
$nama = array("Andy", "Barry", "Charlie");

echo 'weight = ( "Andy"=>"70", "Barry"=>"65", "Charlie"=>"75" )<br><br>';

for ($x = 0; $x < count($weight); $x++) {
    echo $nama[$x] . " is " . $weight[$nama[$x]] . " kg.<br>";
}
?>