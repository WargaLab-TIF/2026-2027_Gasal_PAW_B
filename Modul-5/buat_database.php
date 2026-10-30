<?php
$hostname = "localhost";
$username = "root";
$password = "";

$conn = mysqli_connect($hostname, $username, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "CREATE DATABASE IF NOT EXISTS modul5";

if (mysqli_query($conn, $query)) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . mysqli_error($conn);
}

mysqli_close($conn);
?>