<?php
$weight = array('Andy'=>'70', 'Barry'=>'65', 'Charlie'=>'75');

echo 'weight = ( "' . implode('", "', array_map(
    fn($key, $value) => $key . '"=>"' . $value,
    array_keys($weight),
    array_values($weight)
)) . '" ) ';

echo '<br>Data kedua: ' . $weight['Barry'];
?>