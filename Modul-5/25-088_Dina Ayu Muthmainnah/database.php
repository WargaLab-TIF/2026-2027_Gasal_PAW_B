<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "modul5";

$conn = mysqli_connect($hostname, $username, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "CREATE DATABASE IF NOT EXISTS modul5";

if (mysqli_query($conn, $query)) {
    echo "Database berhasil dibuat!";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>