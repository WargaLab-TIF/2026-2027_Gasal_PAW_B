<?php
$students = array(
    array("Alex", "220401", "0812345678"),
    array("Bianca", "220402", "0812345687"),
    array("Candice", "220403", "0812345665")
);

echo "Data awal:<br>";
echo "students = (<br>";

foreach ($students as $baris) {
    echo "(" . $baris[0] . ", " . $baris[1] . ", " . $baris[2] . ")<br>";
}

echo ")<br><br>";

$students[] = array("Daniel", "220404", "0812345611");
$students[] = array("Elena", "220405", "0812345622");
$students[] = array("Fiona", "220406", "0812345633");
$students[] = array("Gabe", "220407", "0812345644");
$students[] = array("Hannah", "220408", "0812345655");

echo "Data setelah ditambah 5 data lain:<br>";
echo "students = (<br>";

foreach ($students as $baris) {
    echo "(" . $baris[0] . ", " . $baris[1] . ", " . $baris[2] . ")<br>";
}

echo ")<br><br>";

echo '<table border="1" cellspacing="2" cellpadding="2">';
echo "<tr>";
echo "<th>Name</th>";
echo "<th>NIM</th>";
echo "<th>Mobile</th>";
echo "</tr>";

foreach ($students as $baris) {
    echo "<tr>";

    foreach ($baris as $kolom) {
        echo "<td>" . $kolom . "</td>";
    }

    echo "</tr>";
}

echo "</table>";
?>