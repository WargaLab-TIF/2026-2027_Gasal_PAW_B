<?php
require "koneksi.php";
include "midlewire.php";
cekOwner();
require "fungsi.php";

$suppliers = getAllSupplier();
$error = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $kode_barang = htmlspecialchars($_POST["kode_barang"] ?? "");
    $nama_barang = htmlspecialchars($_POST["nama_barang"] ?? "");
    $harga = htmlspecialchars($_POST["harga"] ?? "");
    $stok = htmlspecialchars($_POST["stok"] ?? "");
    $supplier_id = $_POST["supplier_id"] ?? "";

    validateKodeBarang($error, $kode_barang);
    validateNamaBarang($error, $nama_barang);
    validateHarga($error, $harga);
    validateStok($error, $stok);
    validateSupplierId($error, $supplier_id);

    if (empty($error)) {
        tambah_barang($kode_barang, $nama_barang, $harga, $stok, $supplier_id);
        header("Location: barang.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
</head>
<body>
    <?php include "components/navbar.php"; ?>

    <h2>Tambah Data Barang</h2>
    <form action="" method="post">
        <?php include "components/form_barang.php"; ?>
    </form>
</body>
</html>
