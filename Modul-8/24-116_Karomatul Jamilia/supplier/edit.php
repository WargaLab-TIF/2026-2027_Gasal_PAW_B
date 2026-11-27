<?php
$base = "../";
include "../midlewire.php";
require "../fungsi.php";
hanyaOwner();

$error = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int)($_POST["id"] ?? 0);
    $nama = trim($_POST["nama"] ?? "");
    $telp = trim($_POST["telp"] ?? "");
    $alamat = trim($_POST["alamat"] ?? "");

    validasiSupplier($error, $nama, $telp, $alamat);

    if (empty($error)) {
        updateSupplier($id, $nama, $telp, $alamat);
        header("Location: index.php");
        exit();
    }
} else {
    $id = $_GET["id"] ?? 0;
    $data = getSupplierById($id);

    if (!$data) {
        header("Location: index.php");
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
    <meta charset="utf-8">
    <title>Edit Supplier</title>
</head>
<body>
    <?php include "../components/navbar.php"; ?>
    <h2>Edit Supplier</h2>
    <form action="" method="post">
        <?php include "../components/form_supplier.php"; ?>
    </form>
</body>
</html>
