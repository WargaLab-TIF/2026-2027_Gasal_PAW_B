<?php
require "fungsi.php";

$error = [];

$kategoris = getKategori();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["id"] ?? "";
    $judul = htmlspecialchars($_POST["judul"] ?? "");
    $penulis = htmlspecialchars($_POST["penulis"] ?? "");
    $tahun = htmlspecialchars($_POST["tahun"] ?? "");
    $stok = htmlspecialchars($_POST["stok"] ?? "");
    $nama_kategori = $_POST['nama_kategori'] ?? "";

    validateJudul($error, $judul);
    validatePenulis($error, $penulis);
    validateTahun($error, $tahun);
    validateStok($error, $stok);
    validateKategori($error, $nama_kategori);

    if (isset($error["judul"])) {
        $judul = "";
    }
    if (isset($error["penulis"])) {
        $penulis = "";
    }
    if (isset($error["tahun"])) {
        $tahun = "";
    }
    if (isset($error["stok"])) {
        $stok = "";
    }

    if (empty($error)) {
        update_buku($id, $judul, $penulis, $tahun, $stok, $nama_kategori);
        header("Location: index.php");
        exit();
    }
} else {
    $id = $_GET["id_buku"] ?? 0;
    $data = select_id($id);

    if (!$data) {
        header("Location: index.php");
        exit();
    }

    $judul = $data["judul"] ?? "";
    $penulis = $data["penulis"] ?? "";
    $tahun = $data["tahun_terbit"] ?? "";
    $stok = $data["stok"] ?? "";
    $nama_kategori = $data["nama_kategori"] ?? "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Edit Buku</title>
</head>
<body>
    <h1>Edit Buku</h1>
    <form action="" method="post">
        <?php include "components/form.php" ?>
    </form>

    <br>
</body>
</html>
