<?php
include "koneksi.php";

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_GET['Nomor'])) {
    $nomor = htmlspecialchars($_GET['Nomor']);

    $sql = "DELETE FROM data_supplier WHERE Nomor = $nomor";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error saat menghapus: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>