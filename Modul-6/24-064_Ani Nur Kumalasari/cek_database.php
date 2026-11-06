<?php
include "koneksi.php";

echo "<h3>Database yang digunakan PHP:</h3>";

$result = mysqli_query($koneksi, "SELECT DATABASE() AS db");
$data = mysqli_fetch_assoc($result);

echo "Database: " . $data['db'] . "<br><br>";

echo "<h3>Kolom tabel transaksi:</h3>";

$result = mysqli_query($koneksi, "SHOW COLUMNS FROM transaksi");

while ($data = mysqli_fetch_assoc($result)) {
    echo $data['Field'] . " - " . $data['Type'] . "<br>";
}
?>