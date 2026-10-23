<?php
$students = array(
    array("Alex",    "220401", "0812345678"),
    array("Bianca",  "220402", "0812345687"),
    array("Candice", "220403", "0812345665")
);

function tampilArray($students) {
    echo "students = (<br>";
    for ($i = 0; $i < count($students); $i++) {
        echo '("' . implode('", "', $students[$i]) . '")';
        echo ($i < count($students) - 1) ? "," : "";
        echo "<br>";
    }
    echo ")<br><br>";
}

echo "Data awal:<br>";
tampilArray($students);

$students[] = array("Daniel", "220404", "0812345611");
$students[] = array("Elena",  "220405", "0812345622");
$students[] = array("Fiona",  "220406", "0812345633");
$students[] = array("Gabe",   "220407", "0812345644");
$students[] = array("Hannah", "220408", "0812345655");

echo "Data setelah ditambah 5 data lain:<br>";
tampilArray($students);

echo "<table border='1' cellpadding='3' cellspacing='0'>";
echo "<tr><th>Name</th><th>NIM</th><th>Mobile</th></tr>";

for ($i = 0; $i < count($students); $i++) {
    echo "<tr>";
    for ($j = 0; $j < count($students[$i]); $j++) {
        echo "<td>" . $students[$i][$j] . "</td>";
    }
    echo "</tr>";
}

echo "</table>";
?>