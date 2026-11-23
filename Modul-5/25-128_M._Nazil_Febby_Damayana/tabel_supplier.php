<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname   = "dbsupplier";

$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: ".mysqli_connect_error());
}

$query = "CREATE TABLE IF NOT EXISTS supplier (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(255) NOT NULL,
  telp VARCHAR(20) NOT NULL,
  alamat VARCHAR(255) NOT NULL
)";

if (mysqli_query($conn, $query)) {
  echo "Table supplier berhasil dibuat!";
} else {
  echo "Error: ".mysqli_error($conn);
}

mysqli_close($conn);
?>
