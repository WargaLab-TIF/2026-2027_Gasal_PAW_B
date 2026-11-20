
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
    header("Location: suplier.php");
    exit;
}

$id = (int) $_GET['id'];

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM supplier WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$supplier = mysqli_fetch_assoc($hasil);

if (!$supplier) {
    header("Location: suplier.php");
    exit;
}

if (isset($_POST['update'])) {
    $nama = trim($_POST['nama']);
    $telp = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

    if ($nama == "") {
        $error = "Nama supplier wajib diisi.";
    } elseif (strlen($nama) > 100 || strlen($telp) > 12) {
        $error = "Panjang data melebihi batas.";
    } elseif ($telp != "" && !preg_match('/^[0-9]+$/', $telp)) {
        $error = "Nomor telepon harus berupa angka.";
    } else {
        $stmt = mysqli_prepare(
            $koneksi,
            "UPDATE supplier
             SET nama = ?, telp = ?, alamat = ?
             WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sssi",
            $nama,
            $telp,
            $alamat,
            $id
        );

        if (mysqli_stmt_execute($stmt)) {
            header("Location: suplier.php?pesan=edit");
            exit;
        } else {
            $error = "Data supplier gagal diperbarui.";
        }
    }

    $supplier['nama'] = $nama;
    $supplier['telp'] = $telp;
    $supplier['alamat'] = $alamat;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Supplier</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>

<nav>
    <a href="../home/index.php">Home</a>

    <div>
        <span>Data Master</span>
        <div>
            <a href="../barang/barang.php">Data Barang</a>
            <a href="suplier.php">Data Supplier</a>
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

    <h2>Edit Data Supplier</h2>

    <?php if ($error != "") { ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php } ?>

    <form method="POST">

        <label>Nama Supplier</label>
        <input type="text" name="nama"
               value="<?= htmlspecialchars($supplier['nama']); ?>"
               maxlength="100" required>

        <label>Nomor Telepon</label>
        <input type="text" name="telp"
               value="<?= htmlspecialchars($supplier['telp'] ?? ''); ?>"
               maxlength="12">

        <label>Alamat</label>
        <textarea name="alamat"><?= htmlspecialchars($supplier['alamat'] ?? ''); ?></textarea>

        <button type="submit" name="update">Update</button>
        <a href="suplier.php" class="btn-kembali">Kembali</a>

    </form>

</div>

</body>
</html>
