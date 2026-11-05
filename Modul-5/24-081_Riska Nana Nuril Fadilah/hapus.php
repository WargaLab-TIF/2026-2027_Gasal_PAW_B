<?php
require 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("ID supplier tidak ditemukan!");
}

$query = "DELETE FROM supplier WHERE id=$id";

if (mysqli_query($conn, $query)) {
    echo "Data berhasil dihapus!";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>