<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$query = "CREATE DATABASE IF NOT EXISTS db_supplier";

if (mysqli_query($conn, $query)) {
    echo "Database db_supplier berhasil dibuat.";
} else {
    echo "Error: " . mysqli_error($conn);
}
mysqli_close($conn);
?>