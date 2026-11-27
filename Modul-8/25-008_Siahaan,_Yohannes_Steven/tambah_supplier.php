<?php
require "koneksi.php";
include "midlewire.php";
cekOwner();
require "fungsi.php";

$error = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = htmlspecialchars($_POST["nama"] ?? "");
    $telp = htmlspecialchars($_POST["telp"] ?? "");
    $alamat = htmlspecialchars($_POST["alamat"] ?? "");

    validateNama($error, $nama);
    validateTelp($error, $telp);
    validateAlamat($error, $alamat);

    if (empty($error)) {
        tambah_supplier($nama, $telp, $alamat);
        header("Location: supplier.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Supplier</title>
</head>
<body>
    <?php include "components/navbar.php"; ?>

    <h2>Tambah Data Supplier</h2>
    <form action="" method="post">
        <?php include "components/form_supplier.php"; ?>
    </form>
</body>
</html>
