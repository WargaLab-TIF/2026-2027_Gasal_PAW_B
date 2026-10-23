<?php

$students = array(
  array("Alex","220401","0812345678"),
  array("Bianca","220402","0812345687"),
  array("Candice","220403","0812345665")
);

echo "Data awal:<br>";
foreach ($students as $s) {
  echo "(" . $s[0] . ", " . $s[1] . ", " . $s[2] . ")<br>";
}

$students[] = array("Daniel","220404","0812345611");
$students[] = array("Elena","220405","0812345622");
$students[] = array("Fiona","220406","0812345633");
$students[] = array("Gabe","220407","0812345644");
$students[] = array("Hannah","220408","0812345655");

echo "<br>Data setelah ditambah 5 data lain:<br>";
foreach ($students as $s) {
  echo "(" . $s[0] . ", " . $s[1] . ", " . $s[2] . ")<br>";
}

echo "<br>";
echo "<table border='1' cellpadding='3' cellspacing='0'>";
echo "<tr><th>Name</th><th>NIM</th><th>Mobile</th></tr>";
foreach ($students as $s) {
  echo "<tr>";
  echo "<td>" . $s[0] . "</td>";
  echo "<td>" . $s[1] . "</td>";
  echo "<td>" . $s[2] . "</td>";
  echo "</tr>";
}
echo "</table>";

?>