<?php
$base = "../";
include "../midlewire.php";
require "../fungsi.php";
hanyaOwner();

$error = [];
$mode = "edit";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = trim($_POST["id"] ?? "");
    $nama = trim($_POST["nama"] ?? "");
    $jk = $_POST["jk"] ?? "";
    $telp = trim($_POST["telp"] ?? "");
    $alamat = trim($_POST["alamat"] ?? "");

    validasiPelanggan($error, $mode, $id, $nama, $jk, $telp, $alamat);

    if (empty($error)) {
        updatePelanggan($id, $nama, $jk, $telp, $alamat);
        header("Location: index.php");
        exit();
    }
} else {
    $id = $_GET["id"] ?? "";
    $data = getPelangganById($id);

    if (!$data) {
        header("Location: index.php");
        exit();
    }

    $id = $data["id_pelanggan"];
    $nama = $data["nama"];
    $jk = $data["jenis_kelamin"];
    $telp = $data["telp"];
    $alamat = $data["alamat"];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Pelanggan</title>
</head>
<body>
    <?php include "../components/navbar.php"; ?>
    <h2>Edit Pelanggan</h2>
    <form action="" method="post">
        <?php include "../components/form_pelanggan.php"; ?>
    </form>
</body>
</html>
