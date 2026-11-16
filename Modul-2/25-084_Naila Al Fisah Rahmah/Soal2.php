<?php

$matkul = ["PTI", "ALPRO", "DPW", "STRUKDAT", "JARKOM", "PAW", "PSBF", "RPL"];


foreach ($matkul as $value) {

    switch ($value) {
        case "PTI":
            echo "Saya suka $value";
            break;

        case "ALPRO":
            echo "Saya suka $value";
            break;

        case "DPW":
            echo "Saya suka $value";
            break;

        case "STRUKDAT":
            echo "Saya suka $value";
            break;

        case 'JARKOM':
         	echo "Saya suka $value";
         	break;

        case 'PAW':
         	echo "Saya suka $value";
         	break;

        default:
            echo "Saya tidak mengambil matkul $value";
    }

	echo "<br>";

}

?>