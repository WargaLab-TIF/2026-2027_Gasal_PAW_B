<?php
require "fungsi.php";
cekOwner();

$tabel = $_GET["tabel"] ?? "";
cekTabel($tabel);

$aksi = "tambah";
$error = [];
$suppliers = getSupplier();
$data = ["level" => "2"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = ambilInput();

    if ($tabel === "barang") {
        validateKode($error, $data["kode_barang"], $data["id"]);
        validateNamaBarang($error, $data["nama_barang"]);
        validateHarga($error, $data["harga"]);
        validateStok($error, $data["stok"]);
        validateSupplier($error, $data["supplier_id"]);
    } elseif ($tabel === "supplier") {
        validateNama($error, $data["nama"], 100);
        validateTelp($error, $data["telp"]);
        validateAlamat($error, $data["alamat"]);
    } elseif ($tabel === "pelanggan") {
        validateIdPelanggan($error, $data["id"], $aksi);
        validateNama($error, $data["nama"], 100);
        validateJk($error, $data["jenis_kelamin"]);
        validateTelp($error, $data["telp"]);
        validateAlamat($error, $data["alamat"]);
    } elseif ($tabel === "user") {
        validateUsername($error, $data["username"], $data["id"]);
        validatePassword($error, $data["password"], $aksi);
        validateNama($error, $data["nama"], 50);
        validateAlamat($error, $data["alamat"]);
        validateHp($error, $data["hp"]);
        validateLevel($error, $data["level"]);
    }

    if (empty($error)) {
        $tambah = "tambah_" . $tabel;
        $tambah($data);
        header("Location: index.php?halaman=" . $tabel);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah <?= $tabel ?></title>
</head>
<body>
  <h1>Tambah <?= $tabel ?></h1>
  <form action="" method="post">
      <?php include "components/form.php" ?>
  </form>
  <br>
</body>
</html>