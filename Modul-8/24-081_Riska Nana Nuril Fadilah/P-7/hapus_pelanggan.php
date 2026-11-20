<?php
require 'koneksi.php';
include 'midlewire.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("ID pelanggan tidak ditemukan!");
}

$query = "DELETE FROM pelanggan WHERE id='$id'";

if (mysqli_query($conn, $query)) {
    header("Location: pelanggan.php");
    exit;
} else {
    echo "Error: " . mysqli_error($conn);
}
?>