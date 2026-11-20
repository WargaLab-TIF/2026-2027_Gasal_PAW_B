<?php
require "koneksi.php";
include "midlewire.php";
cekOwner();
require "fungsi.php";

$error = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"] ?? "";
    $nama = htmlspecialchars($_POST["nama"] ?? "");
    $telp = htmlspecialchars($_POST["telp"] ?? "");
    $alamat = htmlspecialchars($_POST["alamat"] ?? "");

    validateNama($error, $nama);
    validateTelp($error, $telp);
    validateAlamat($error, $alamat);

    if (empty($error)) {
        update_supplier($id, $nama, $telp, $alamat);
        header("Location: supplier.php");
        exit();
    }
} else {
    $id = $_GET["id"] ?? 0;
    $data = getSupplierById($id);
    if (!$data) {
        header("Location: supplier.php");
        exit();
    }
    $nama = $data["nama"];
    $telp = $data["telp"];
    $alamat = $data["alamat"];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Supplier</title>
</head>
<body>
    <?php include "components/navbar.php"; ?>

    <h2>Edit Data Supplier</h2>
    <form action="" method="post">
        <?php include "components/form_supplier.php"; ?>
    </form>
</body>
</html>
