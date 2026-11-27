<?php
require "koneksi.php";
include "midlewire.php";
cekOwner();
require "fungsi.php";

$error = [];
$is_edit = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = htmlspecialchars($_POST["id"] ?? "");
    $nama = htmlspecialchars($_POST["nama"] ?? "");
    $jenis_kelamin = $_POST["jenis_kelamin"] ?? "";
    $telp = htmlspecialchars($_POST["telp"] ?? "");
    $alamat = htmlspecialchars($_POST["alamat"] ?? "");

    validateIdPelanggan($error, $id);
    validateNama($error, $nama);
    validateJenisKelamin($error, $jenis_kelamin);
    validateTelp($error, $telp);
    validateAlamat($error, $alamat);

    if (empty($error) && getPelangganById($id)) {
        $error["id"] = "ID Pelanggan sudah digunakan";
    }

    if (empty($error)) {
        tambah_pelanggan($id, $nama, $jenis_kelamin, $telp, $alamat);
        header("Location: pelanggan.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pelanggan</title>
</head>
<body>
    <?php include "components/navbar.php"; ?>

    <h2>Tambah Data Pelanggan</h2>
    <form action="" method="post">
        <?php include "components/form_pelanggan.php"; ?>
    </form>
</body>
</html>
