<?php 
$matkul = ["PTI","ALPRO","DPW","STRUKDAT","JARKOM","PAW","PSBF","RPL"];

foreach ($matkul as $namaMatkul) {
    switch ($namaMatkul) {
        case "PTI":
            echo "Saya suka PTI<br>";
            break;
        case "ALPRO":
            echo "Saya suka ALPRO<br>";
            break;
        case "DPW":
            echo "Saya suka DPW<br>";
            break;
        case "STRUKDAT":
            echo "Saya suka STRUKDAT<br>";
            break;
        case "JARKOM":
            echo "Saya suka JARKO<br>";
            break;
        case "PAW":
            echo "Saya suka PAW<br>";
            break;
        default:
            echo "Saya tidak mengambil matkul $namaMatkul<br>";
            break;
    }
}
 ?>