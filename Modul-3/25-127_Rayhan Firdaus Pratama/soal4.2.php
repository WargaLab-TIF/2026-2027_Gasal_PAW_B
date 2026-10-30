<?php
$weight = array("Andy"=>"70", "Barry"=>"65", "Charlie"=>"75");

echo "weight = ";
print_r($weight);
echo "<br><br>";
$names = array_keys($weight);

for ($i = 0; $i < count($weight); $i++) {
    echo $names[$i] . " is " . $weight[$names[$i]] . " kg.<br>";
}
?>