<?php
function sum($x, $y) {
    $z = $x + $y;
    $q = $x - $y;
    $w = $x * $y;
    $r = $x / $y;
    echo "penjumlahan$x + $y = $z <br>";
    echo "pengurangan$x - $y = $q <br>";
    echo "perkalian$x * $y = $w <br>";
    echo "pembagian$x / $y = $r <br>";

}
sum(10, 5);