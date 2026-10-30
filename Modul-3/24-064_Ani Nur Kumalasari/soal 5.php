<?php
$students = array(
    "Alex" => array("220401", "0812345678"),
    "Bianca" => array("220402", "0812345687"),
    "Candice" => array("220403", "0812345665")
);

echo "Data awal<br>";
echo "students = (<br>";

foreach ($students as $nama => $data) {
    echo '("' . $nama . '", "' . $data[0] . '", "' . $data[1] . '"),<br>';
}

echo ")<br><br>";

// Menambahkan lima data mahasiswa
$students["Daniel"] = array("220404", "0812345611");
$students["Elena"] = array("220405", "0812345622");
$students["Fiona"] = array("220406", "0812345633");
$students["Gabe"] = array("220407", "0812345644");
$students["Hannah"] = array("220408", "0812345655");

echo "Data setelah ditambah 5 data lain:<br>";
echo "students = (<br>";

foreach ($students as $nama => $data) {
    echo '("' . $nama . '", "' . $data[0] . '", "' . $data[1] . '"),<br>';
}

echo ")<br><br>";

// Menampilkan tabel mahasiswa
echo "<table border='1' cellspacing='0' cellpadding='3'>";
echo "<tr><th>Name</th><th>NIM</th><th>Mobile</th></tr>";

foreach ($students as $nama => $data) {
    echo "<tr>";
    echo "<td>" . $nama . "</td>";
    echo "<td>" . $data[0] . "</td>";
    echo "<td>" . $data[1] . "</td>";
    echo "</tr>";
}

echo "</table>";
?>


