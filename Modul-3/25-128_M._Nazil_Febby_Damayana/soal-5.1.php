<?php
$students = array(
    array("Alex", "220401", "0812345678"),
    array("Bianca", "220402", "0812345687"),
    array("Candice", "220403", "0812345665")
);
echo "Data awal:<br>";
echo "students = (<br>";

foreach ($students as $data) {
    echo '("'.$data[0].'", "'.$data[1].'", "'.$data[2].'"),<br>';
}
echo ")<br><br>";
$students[] = array("Daniel", "220404", "0812345611");
$students[] = array("Elena", "220405", "0812345622");
$students[] = array("Fiona", "220406", "0812345633");
$students[] = array("Gabe", "220407", "0812345644");
$students[] = array("Hannah", "220408", "0812345655");
echo "Data setelah ditambah 5 data lain:<br>";
echo "students = (<br>";

foreach ($students as $data) {
    echo '("'.$data[0].'", "'.$data[1].'", "'.$data[2].'"),<br>';
}
echo ")<br><br>";
echo "<table border='1' cellspacing='0' cellpadding='2'>";
echo "<tr><th>Name</th><th>NIM</th><th>Mobile</th></tr>";

foreach ($students as $data) {
    echo "<tr>";
    echo "<td>".$data[0]."</td>";
    echo "<td>".$data[1]."</td>";
    echo "<td>".$data[2]."</td>";
    echo "</tr>";
}
echo "</table>";
?>