<?php
include "koneksi.php";

$id  = (int) $_GET["id"];
$sql = "DELETE FROM supplier WHERE id=$id";

if (mysqli_query($koneksi, $sql)) {
    echo "Data berhasil dihapus <br><br>";
    echo "<a href='tampil.php'><button>Kembali</button></a><br><br>";
    exit;
} else {
    echo "Data gagal dihapus: " . mysqli_error($koneksi);
}
?>
