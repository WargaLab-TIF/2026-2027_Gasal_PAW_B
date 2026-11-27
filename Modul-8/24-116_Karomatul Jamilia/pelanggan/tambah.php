<?php
$base = "../";
include "../midlewire.php";
require "../fungsi.php";
hanyaOwner();

$error = [];
$mode = "tambah";
$id = $nama = $jk = $telp = $alamat = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = trim($_POST["id"] ?? "");
    $nama = trim($_POST["nama"] ?? "");
    $jk = $_POST["jk"] ?? "";
    $telp = trim($_POST["telp"] ?? "");
    $alamat = trim($_POST["alamat"] ?? "");

    validasiPelanggan($error, $mode, $id, $nama, $jk, $telp, $alamat);

    if (empty($error)) {
        tambahPelanggan($id, $nama, $jk, $telp, $alamat);
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tambah Pelanggan</title>
</head>
<body>
    <?php include "../components/navbar.php"; ?>
    <h2>Tambah Pelanggan</h2>
    <form action="" method="post">
        <?php include "../components/form_pelanggan.php"; ?>
    </form>
</body>
</html>
