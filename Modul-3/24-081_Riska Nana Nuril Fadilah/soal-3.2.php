<?php
$weight = array("Andy" => "70", "Barry" => "65", "Charlie" => "75");

echo "weight = ( ";

foreach ($weight as $nama => $berat) {
    echo "$nama => $berat, ";
}

echo ")";
echo "<br>Data kedua: " . $weight["Barry"];
?>