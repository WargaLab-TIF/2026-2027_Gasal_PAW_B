<?php
require "koneksi.php";
include "midlewire.php";
cekOwner();
require "fungsi.php";

$error = [];
$is_edit = true;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = htmlspecialchars($_POST["id"] ?? "");
    $nama = htmlspecialchars($_POST["nama"] ?? "");
    $jenis_kelamin = $_POST["jenis_kelamin"] ?? "";
    $telp = htmlspecialchars($_POST["telp"] ?? "");
    $alamat = htmlspecialchars($_POST["alamat"] ?? "");

    validateNama($error, $nama);
    validateJenisKelamin($error, $jenis_kelamin);
    validateTelp($error, $telp);
    validateAlamat($error, $alamat);

    if (empty($error)) {
        update_pelanggan($id, $nama, $jenis_kelamin, $telp, $alamat);
        header("Location: pelanggan.php");
        exit();
    }
} else {
    $id = $_GET["id"] ?? "";
    $data = getPelangganById($id);
    if (!$data) {
        header("Location: pelanggan.php");
        exit();
    }
    $nama = $data["nama"];
    $jenis_kelamin = $data["jenis_kelamin"];
    $telp = $data["telp"];
    $alamat = $data["alamat"];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pelanggan</title>
</head>
<body>
    <?php include "components/navbar.php"; ?>

    <h2>Edit Data Pelanggan</h2>
    <form action="" method="post">
        <?php include "components/form_pelanggan.php"; ?>
    </form>
</body>
</html>
