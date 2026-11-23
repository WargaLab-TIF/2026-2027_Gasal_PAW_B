<?php
include "koneksi.php";

$id = (int) $_POST['id'];

$sql = "DELETE FROM supplier WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    header("Location: index.php");
    exit;
} else {
    echo "Data gagal dihapus: " . mysqli_error($conn);
}

mysqli_close($conn);
?>