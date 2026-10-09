<?php

$students = array(
    array("Alex",    "220401", "0812345678"),
    array("Bianca",  "220402", "0812345687"),
    array("Candice", "220403", "0812345665")
);

function tampil($arr) {
    $jumlah = count($arr);
    $no = 0;
    echo "(<br>";
    foreach ($arr as $row) {
        echo '("' . $row[0] . '", "' . $row[1] . '", "' . $row[2] . '")';
        $no++;
        if ($no < $jumlah) { echo ","; }
        echo "<br>";
    }
    echo ")";
}

echo "Data awal:<br>students = "; tampil($students); echo "<br><br>";

$students[] = array("Daniel", "220404", "0812345611");
$students[] = array("Elena",  "220405", "0812345622");
$students[] = array("Fiona",  "220406", "0812345633");
$students[] = array("Gabe",   "220407", "0812345644");
$students[] = array("Hannah", "220408", "0812345655");

echo "Data setelah ditambah 5 data lain:<br>students = "; tampil($students); echo "<br><br>";

echo "<table border='1'>";
echo "<tr><th>Name</th><th>NIM</th><th>Mobile</th></tr>";
foreach ($students as $s) {
    echo "<tr><td>" . $s[0] . "</td><td>" . $s[1] . "</td><td>" . $s[2] . "</td></tr>";
}
echo "</table>";
?>
