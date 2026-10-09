<?php

$fruits = array("Avocado", "Blueberry", "Cherry", "Durian", "Elderberry", "Fig", "Grape", "Honeydew");

echo "Data " . $fruits[1] . " dihapus" . "<br>";
unset($fruits[1]);

echo 'fruits = ( "' . $fruits[0] . '", "' . $fruits[2] . '", "' . $fruits[3] . '", "'
    . $fruits[4] . '", "' . $fruits[5] . '", "' . $fruits[6] . '", "'
    . $fruits[7] . '")<br>';

echo "Nilai dengan indeks tertinggi: " . $fruits[array_key_last($fruits)];

?>