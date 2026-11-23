<?php
//5.1
$students = array(
    array("Alex", "220401", "0812345678"),
    array("Bianca", "220402", "081234567"),
    array("Candice", "220403", "0812345665")
);

echo "Data awal:<br>";
echo "students = (<br>";

for ($i = 0; $i < count($students); $i++) {
    echo '("' . $students[$i][0] . '", ';
    echo '"' . $students[$i][1] . '", ';
    echo '"' . $students[$i][2] . '")';

    if ($i < count($students) - 1) {
        echo ",<br>";
    } else {
        echo "<br>";
    }
}

$students[] = array("Daniel", "220404", "0812345611");
$students[] = array("Elena", "220405", "0812345622");
$students[] = array("Fiona", "220406", "0812345633");
$students[] = array("Gabe", "220407", "0812345644");
$students[] = array("Hannah", "220408", "0812345655");

echo "<br><br>";
echo "Data setelah ditambah 5 data lain:<br>";
echo "students = (<br>";

for ($i = 0; $i < count($students); $i++) {
    echo '("' . $students[$i][0] . '", ';
    echo '"' . $students[$i][1] . '", ';
    echo '"' . $students[$i][2] . '")';

    if ($i < count($students) - 1) {
        echo ",<br>";
    } else {
        echo "<br>";
    }
}

echo ")<br><br>";

echo "<table border='1' cellpadding='4' cellspacing='0'>";
echo "<tr>";
echo "<th>Name</th>";
echo "<th>NIM</th>";
echo "<th>Mobile</th>";
echo "</tr>";

for ($i = 0; $i < count($students); $i++) {
    echo "<tr>";
    echo "<td>" . $students[$i][0] . "</td>";
    echo "<td>" . $students[$i][1] . "</td>";
    echo "<td>" . $students[$i][2] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>