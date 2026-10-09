<?php
$weight = array("Andy" => "70", "Barry" => "65", "Charlie" => "75");
echo "weight = ";
print_r($weight);
echo "<br><br>";
$keys = array_keys($weight);
$values = array_values($weight);
for ($i = 0; $i < count($weight); $i++) {
    echo $keys[$i] . " is " . $values[$i] . " kg.<br>";
}
?>