<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "CREATE DATABASE IF NOT EXISTS db_supplier";
if (mysqli_query($conn, $sql)) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . mysqli_error($conn) . "<br>";
}

mysqli_select_db($conn, "db_supplier");

// sql to create table
$sql = "CREATE TABLE IF NOT EXISTS supplier (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
nama VARCHAR(100) NOT NULL,
telp VARCHAR(20) NOT NULL,
alamat VARCHAR(150) NOT NULL
)";

if (mysqli_query($conn, $sql)) {
    echo "Table supplier created successfully<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

$sql = "INSERT INTO supplier (nama, telp, alamat) VALUES ('PT. Maju Bersama', '08123456', 'Surabaya');";
$sql .= "INSERT INTO supplier (nama, telp, alamat) VALUES ('PT. Bintang Sakti', '081515563', 'Bangkalan');";
$sql .= "INSERT INTO supplier (nama, telp, alamat) VALUES ('PT. Segar Segar', '0845454663', 'Surabaya');";

if (mysqli_multi_query($conn, $sql)) {
    echo "New records created successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
echo "<br><a href='index.php'>Kembali ke Index</a>";
?>
