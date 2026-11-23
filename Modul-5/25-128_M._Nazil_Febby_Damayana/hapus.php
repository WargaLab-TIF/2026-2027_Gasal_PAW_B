<?php
include "koneksi.php";

$id = $_GET['id'];

$query = "DELETE FROM supplier WHERE id=$id";

if (mysqli_query($conn, $query)) {
    header("Location: index.php?pesan=Data berhasil dihapus");
} else {
    echo "Error: ".mysqli_error($conn);
}
?>
