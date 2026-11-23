
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

if (isset($_POST['simpan'])) {
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
            "INSERT INTO supplier (nama, telp, alamat)
             VALUES (?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sss",
            $nama,
            $telp,
            $alamat
        );

        if (mysqli_stmt_execute($stmt)) {
            header("Location: suplier.php?pesan=tambah");
            exit;
        } else {
            $error = "Data supplier gagal ditambahkan.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Supplier</title>
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

    <h2>Tambah Data Supplier</h2>

    <?php if ($error != "") { ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php } ?>

    <form method="POST">

        <label>Nama Supplier</label>
        <input type="text" name="nama"
               placeholder="Masukkan nama supplier"
               maxlength="100"
               value="<?= htmlspecialchars($_POST['nama'] ?? ''); ?>"
               required>

        <label>Nomor Telepon</label>
        <input type="text" name="telp"
               placeholder="Masukkan nomor telepon"
               maxlength="12"
               value="<?= htmlspecialchars($_POST['telp'] ?? ''); ?>">

        <label>Alamat</label>
        <textarea name="alamat"
                  placeholder="Masukkan alamat supplier"><?= htmlspecialchars($_POST['alamat'] ?? ''); ?></textarea>

        <button type="submit" name="simpan">Simpan</button>
        <a href="suplier.php" class="btn-kembali">Kembali</a>

    </form>

</div>

</body>
</html>
