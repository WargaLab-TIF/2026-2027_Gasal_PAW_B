<?php
$base = "../";
include "../midlewire.php";
require "../fungsi.php";
hanyaOwner();

$suppliers = getSupplier();
$error = [];
$id = 0;
$kode = $nama = $harga = $stok = $supplier_id = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $kode = trim($_POST["kode"] ?? "");
    $nama = trim($_POST["nama"] ?? "");
    $harga = trim($_POST["harga"] ?? "");
    $stok = trim($_POST["stok"] ?? "");
    $supplier_id = $_POST["supplier"] ?? "";

    validasiBarang($error, 0, $kode, $nama, $harga, $stok, $supplier_id);

    if (empty($error)) {
        tambahBarang($kode, $nama, $harga, $stok, $supplier_id);
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tambah Barang</title>
</head>
<body>
    <?php include "../components/navbar.php"; ?>
    <h2>Tambah Barang</h2>
    <form action="" method="post">
        <?php include "../components/form_barang.php"; ?>
    </form>
</body>
</html>
