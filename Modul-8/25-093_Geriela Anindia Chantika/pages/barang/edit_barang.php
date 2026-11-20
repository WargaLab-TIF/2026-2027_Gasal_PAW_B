
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../../auth/login.php");
    exit;
}

if ($_SESSION['role'] !== 'owner') {
    header("Location: ../home/index.php");
    exit;
}

require_once "../../config/koneksi.php";

$error = "";

if (!isset($_GET['id'])) {
    header("Location: barang.php");
    exit;
}

$id = (int) $_GET['id'];

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM barang WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$barang = mysqli_fetch_assoc($hasil);

if (!$barang) {
    header("Location: barang.php");
    exit;
}

if (isset($_POST['update'])) {
    $kode_barang = trim($_POST['kode_barang']);
    $nama_barang = trim($_POST['nama_barang']);
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $supplier_id = $_POST['supplier_id'];

    if ($kode_barang == "" || $nama_barang == "" ||
        $harga == "" || $stok == "" || $supplier_id == "") {

        $error = "Semua data harus diisi.";

    } elseif (!is_numeric($harga) || $harga < 0 ||
              !ctype_digit($stok) ||
              !ctype_digit($supplier_id)) {

        $error = "Harga, stok, atau supplier tidak valid.";

    } else {
        $stmt = mysqli_prepare(
            $koneksi,
            "SELECT id FROM barang
             WHERE kode_barang = ? AND id != ?"
        );

        mysqli_stmt_bind_param($stmt, "si", $kode_barang, $id);
        mysqli_stmt_execute($stmt);

        $cek = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($cek) > 0) {
            $error = "Kode barang sudah digunakan.";
        } else {
            $harga = (int) $harga;
            $stok = (int) $stok;
            $supplier_id = (int) $supplier_id;

            $stmt = mysqli_prepare(
                $koneksi,
                "UPDATE barang
                 SET kode_barang = ?,
                     nama_barang = ?,
                     harga = ?,
                     stok = ?,
                     supplier_id = ?
                 WHERE id = ?"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "ssiiii",
                $kode_barang,
                $nama_barang,
                $harga,
                $stok,
                $supplier_id,
                $id
            );

            if (mysqli_stmt_execute($stmt)) {
                header("Location: barang.php?pesan=edit");
                exit;
            } else {
                $error = "Data barang gagal diperbarui.";
            }
        }
    }

    $barang['kode_barang'] = $kode_barang;
    $barang['nama_barang'] = $nama_barang;
    $barang['harga'] = $harga;
    $barang['stok'] = $stok;
    $barang['supplier_id'] = $supplier_id;
}

$supplier = mysqli_query(
    $koneksi,
    "SELECT * FROM supplier ORDER BY nama ASC"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>

<nav>
    <a href="../home/index.php">Home</a>

    <div>
        <span>Data Master</span>
        <div>
            <a href="barang.php">Data Barang</a>
            <a href="../supplier/supplier.php">Data Supplier</a>
            <a href="../pelanggan/pelanggan.php">Data Pelanggan</a>
            <a href="../user/user.php">Data User</a>
        </div>
    </div>

    <a href="../transaksi/transaksi.php">Transaksi</a>
    <a href="../laporan/laporan.php">Laporan</a>

    <div class="user-dropdown">
    <button class="user-button" type="button">
        <?= htmlspecialchars($_SESSION['nama']); ?>
        <span>▼</span>
    </button>

    <div class="user-dropdown-content">
        <a href="../../auth/logout.php">Logout</a>
    </div>
    </div>
</nav>

<div class="container">

    <h2>Edit Data Barang</h2>

    <?php if ($error != "") { ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php } ?>

    <form method="POST">

        <label>Kode Barang</label>
        <input type="text" name="kode_barang"
               value="<?= htmlspecialchars($barang['kode_barang']); ?>"
               maxlength="10" required>

        <label>Nama Barang</label>
        <input type="text" name="nama_barang"
               value="<?= htmlspecialchars($barang['nama_barang']); ?>"
               maxlength="100" required>

        <label>Harga</label>
        <input type="number" name="harga"
               value="<?= htmlspecialchars($barang['harga']); ?>"
               min="0" required>

        <label>Stok</label>
        <input type="number" name="stok"
               value="<?= htmlspecialchars($barang['stok']); ?>"
               min="0" required>

        <label>Supplier</label>
        <select name="supplier_id" required>
            <option value="">-- Pilih Supplier --</option>

            <?php while ($data = mysqli_fetch_assoc($supplier)) { ?>
                <option value="<?= $data['id']; ?>"
                    <?= $barang['supplier_id'] == $data['id']
                        ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($data['nama']); ?>
                </option>
            <?php } ?>

        </select>

        <button type="submit" name="update">Update</button>
        <a href="barang.php" class="btn-kembali">Kembali</a>

    </form>

</div>

</body>
</html>
