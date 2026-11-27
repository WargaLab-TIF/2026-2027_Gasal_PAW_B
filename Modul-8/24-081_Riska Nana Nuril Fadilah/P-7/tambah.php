<?php
include "midlewire.php";
require "fungsi.php";

$kategoris = getKategori();

$error = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $judul = htmlspecialchars($_POST["judul"] ?? "");
    $penulis = htmlspecialchars($_POST["penulis"] ?? "");
    $tahun = htmlspecialchars($_POST["tahun"] ?? "");
    $stok = htmlspecialchars($_POST["stok"] ?? "");
    $nama_kategori = $_POST["nama_kategori"] ?? "";

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
        tambah_buku($judul, $penulis, $tahun, $stok, $nama_kategori);
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tambah Buku</title>
</head>
<body>
  <h1>Tambah Buku</h1>
  <form action="" method="post">
      <?php include "components/form.php" ?>
  </form>
  <br>
</body>
</html>
