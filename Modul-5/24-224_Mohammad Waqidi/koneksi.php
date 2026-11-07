<?php
$conn = mysqli_connect("localhost", "root", "", "modul_5");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>