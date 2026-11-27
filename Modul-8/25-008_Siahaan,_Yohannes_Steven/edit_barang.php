<?php
require "koneksi.php";
include "midlewire.php";
cekOwner();
require "fungsi.php";

$suppliers = getAllSupplier();
$error = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"] ?? "";
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
        update_barang($id, $kode_barang, $nama_barang, $harga, $stok, $supplier_id);
        header("Location: barang.php");
        exit();
    }
} else {
    $id = $_GET["id"] ?? 0;
    $data = getBarangById($id);
    if (!$data) {
        header("Location: barang.php");
        exit();
    }
    $kode_barang = $data["kode_barang"];
    $nama_barang = $data["nama_barang"];
    $harga = $data["harga"];
    $stok = $data["stok"];
    $supplier_id = $data["supplier_id"];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
</head>
<body>
    <?php include "components/navbar.php"; ?>

    <h2>Edit Data Barang</h2>
    <form action="" method="post">
        <?php include "components/form_barang.php"; ?>
    </form>
</body>
</html>
