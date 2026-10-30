<?php
$fruits = array("Avocado", "Bluebery", "Cherry");
array_push($fruits, "Durian", "Elderberry", "Fig" , "Grape", "Honeydew");

echo "fruits = ";
foreach ($fruits as $a){
    echo " " . $a;
};

echo "<br>Data " . $fruits[1] . " dihapus";
unset($fruits[1]);

echo "<br>fruits = ";
foreach ($fruits as $a){
    echo " " . $a;
};
$a = count($fruits);
echo "<br>nilai dengan indeks tertinggi: ";
echo $fruits[$a];

?>