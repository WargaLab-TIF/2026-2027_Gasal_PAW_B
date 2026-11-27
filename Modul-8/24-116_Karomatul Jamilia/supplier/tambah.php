<?php
$base = "../";
include "../midlewire.php";
require "../fungsi.php";
hanyaOwner();

$error = [];
$id = 0;
$nama = $telp = $alamat = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = trim($_POST["nama"] ?? "");
    $telp = trim($_POST["telp"] ?? "");
    $alamat = trim($_POST["alamat"] ?? "");

    validasiSupplier($error, $nama, $telp, $alamat);

    if (empty($error)) {
        tambahSupplier($nama, $telp, $alamat);
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tambah Supplier</title>
</head>
<body>
    <?php include "../components/navbar.php"; ?>
    <h2>Tambah Supplier</h2>
    <form action="" method="post">
        <?php include "../components/form_supplier.php"; ?>
    </form>
</body>
</html>
