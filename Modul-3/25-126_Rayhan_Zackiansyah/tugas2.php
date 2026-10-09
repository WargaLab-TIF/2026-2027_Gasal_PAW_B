<?php
//2.1
echo "Soal 2.1<br>";
$fruits = array("Avocado", "Blueberry", "Cherry");
$tambahbuah = array("Mango", "Orange", "Banana", "Apple", "Grape");

for ($i = 0; $i < count($tambahbuah); $i++) {
    $fruits[] = $tambahbuah[$i];
}

$length = count($fruits);

echo "Panjang array saat ini: " . $length . "<br><br>";

for ($x = 0; $x < $length; $x++) {
    echo $fruits[$x];
    echo "<br>";
}

echo "<br><br>";

//2.2

echo "Soal 2.2<br>";

$vegies = array("Carrot", "Broccoli", "Spinach");
$panjangVegies = count($vegies);

for ($x = 0; $x < $panjangVegies; $x++) {
    echo $vegies[$x];
    echo "<br>";
}
?>