<?php
$base = "../";
include "../midlewire.php";
require "../fungsi.php";
hanyaOwner();

$suppliers = getSupplier();
$error = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int)($_POST["id"] ?? 0);
    $kode = trim($_POST["kode"] ?? "");
    $nama = trim($_POST["nama"] ?? "");
    $harga = trim($_POST["harga"] ?? "");
    $stok = trim($_POST["stok"] ?? "");
    $supplier_id = $_POST["supplier"] ?? "";

    validasiBarang($error, $id, $kode, $nama, $harga, $stok, $supplier_id);

    if (empty($error)) {
        updateBarang($id, $kode, $nama, $harga, $stok, $supplier_id);
        header("Location: index.php");
        exit();
    }
} else {
    $id = $_GET["id"] ?? 0;
    $data = getBarangById($id);

    if (!$data) {
        header("Location: index.php");
        exit();
    }

    $kode = $data["kode_barang"];
    $nama = $data["nama_barang"];
    $harga = $data["harga"];
    $stok = $data["stok"];
    $supplier_id = $data["supplier_id"];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Barang</title>
</head>
<body>
    <?php include "../components/navbar.php"; ?>
    <h2>Edit Barang</h2>
    <form action="" method="post">
        <?php include "../components/form_barang.php"; ?>
    </form>
</body>
</html>
