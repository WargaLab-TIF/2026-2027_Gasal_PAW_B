<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "db_penjualan";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
