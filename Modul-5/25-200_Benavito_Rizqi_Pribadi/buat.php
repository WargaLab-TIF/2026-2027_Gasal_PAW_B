<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_supplier"; // setelah membuat database baru mengetikan dbname ini

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";

// $sql = "CREATE DATABASE db_supplier";

// if (mysqli_query($conn, $sql)) {
// 	echo "Database created successfully";
// } else {
// 	echo "Error creating database: " . mysqli_error($conn);
// }

// mysqli_close($conn);

// $sql = "CREATE TABLE data_supplier (
// Nomor INT(6) AUTO_INCREMENT PRIMARY KEY,
// Nama VARCHAR(30) NOT NULL,
// Telp VARCHAR(30) NOT NULL,
// Alamat VARCHAR(50) NOT NULL
// )";

// if (mysqli_query($conn, $sql)) {
// 	echo "Table created successfully";
// } else {
// 	echo "Error creating table: " . mysqli_error($conn);
// }

// mysqli_close($conn);

?>