<?php
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");
$nama = array_keys($weight);
echo "weight = ";
print_r($weight);
for($i=0; $i<count($weight); $i++){
    echo "<br> $nama[$i] is " . $weight[$nama[$i]] . " kg";
}
?>