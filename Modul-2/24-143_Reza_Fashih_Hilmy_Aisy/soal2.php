<?php

$matkul = ["PTI", "ALPRO", "DPW", "STRUKDAT", "JARKOM", "PAW", "PSBF", "RPL"];

foreach ($matkul as $namaMatkul) {

    switch ($namaMatkul) {
        case "PTI":
            echo "Saya suka PTI";
            break;

        case "ALPRO":
            echo "Saya suka ALPRO";
            break;

        case "DPW":
            echo "Saya suka DPW";
            break;

        case "STRUKDAT":
            echo "Saya suka STRUKDAT";
            break;

        case "JARKOM":
            echo "Saya suka JARKOM";
            break;

        case "PAW":
            echo "Saya suka PAW";
            break;

        default:
            echo "Saya tidak mengambil matkul " . $namaMatkul;
    }

    echo "<br>";
}
?>