<?php
require 'koneksi.php';
include 'midlewire.php';

if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];

    $query = "DELETE FROM user WHERE id_user='$id_user'";

    if (mysqli_query($conn, $query)) {
        header("Location: user.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    die("ID user tidak ditemukan!");
}
?>