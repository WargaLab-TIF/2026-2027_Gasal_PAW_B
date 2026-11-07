<?php
include "koneksi.php";

$id = $_GET['id'];

$sql = "DELETE FROM suplier WHERE id = '$id'";

if (mysqli_query($conn, $sql)) {
    header("Location: index.php");
} else {
    echo "Data gagal dihapus: " . mysqli_error($conn);
}

mysqli_close($conn);
?>