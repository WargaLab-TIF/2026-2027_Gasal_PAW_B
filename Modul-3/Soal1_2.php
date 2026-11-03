<?php
$fruits = array('Avocado', 'Blueberry', 'Cherry');
$fruits[] = 'Durian';
$fruits[] = 'Elderberry';
$fruits[] = 'Fig';
$fruits[] = 'Grape';
$fruits[] = 'Honeydew';

unset($fruits[1]);
echo 'Data Blueberry dihapus.<br>';
echo 'fruits = ( "' . implode('", "', $fruits) . '" )<br>';
echo 'Nilai dengan indeks tertinggi: ' . end($fruits);
?>