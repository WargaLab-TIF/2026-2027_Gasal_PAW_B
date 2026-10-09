<?php
// 1. Data awal 3 siswa
$students = array(
    array("Alex", "220401", "0812345678"),
    array("Bianca", "220402", "0812345687"),
    array("Candice", "220403", "0812345665")
);

// Tampilkan Data awal
echo "Data awal:<br>";
echo "students = {<br>";
foreach ($students as $s) {
    echo "(\"" . $s[0] . "\", \"" . $s[1] . "\", \"" . $s[2] . "\"),<br>";
}
echo "}<br><br>";

// 2. Tambahkan 5 data baru sesuai gambar
$students[] = array("Daniel", "220404", "0812345611");
$students[] = array("Elena", "220405", "0812345622");
$students[] = array("Fiona", "220406", "0812345633");
$students[] = array("Gabe", "220407", "0812345644");
$students[] = array("Hannah", "220408", "0812345655");

// Tampilkan Data setelah ditambah 5 data lain
echo "Data setelah ditambah 5 data lain:<br>";
echo "students = {<br>";
foreach ($students as $s) {
    echo "(\"" . $s[0] . "\", \"" . $s[1] . "\", \"" . $s[2] . "\"),<br>";
}
echo "}<br><br>";

// 3. Tampilkan seluruhnya dalam bentuk tabel HTML
echo "<table border='1' cellpadding='5' cellspacing='0'>";
echo "<tr>
        <th>Name</th>
        <th>NIM</th>
        <th>Mobile</th>
      </tr>";

foreach ($students as $s) {
    echo "<tr>";
    echo "<td>" . $s[0] . "</td>";
    echo "<td>" . $s[1] . "</td>";
    echo "<td>" . $s[2] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>