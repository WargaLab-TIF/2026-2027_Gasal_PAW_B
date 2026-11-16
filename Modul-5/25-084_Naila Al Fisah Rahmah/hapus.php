
<?php
require 'koneksi.php';

mysqli_select_db($conn, "Modul 5");

$id = (int) $_GET['id'];

$query = "DELETE FROM dataMaster WHERE id = $id";

if (mysqli_query($conn, $query)) {
    header("Location: index.php");
    exit;
} else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
}
?>
