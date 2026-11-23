
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
    $id = strtoupper(trim($_POST['id']));
    $nama = trim($_POST['nama']);
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $telp = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

    if ($id == "" || $nama == "" || $jenis_kelamin == "") {
        $error = "ID, nama, dan jenis kelamin wajib diisi.";
    } elseif (!in_array($jenis_kelamin, ['L', 'P'])) {
        $error = "Jenis kelamin tidak valid.";
    } elseif (strlen($id) > 20 || strlen($nama) > 100 ||
              strlen($telp) > 12) {
        $error = "Panjang data melebihi batas.";
    } elseif ($telp != "" && !preg_match('/^[0-9]+$/', $telp)) {
        $error = "Nomor telepon harus berupa angka.";
    } else {
        $stmt = mysqli_prepare(
            $koneksi,
            "SELECT id FROM pelanggan WHERE id = ?"
        );

        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);

        $hasil = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($hasil) > 0) {
            $error = "ID pelanggan sudah digunakan.";
        } else {
            $stmt = mysqli_prepare(
                $koneksi,
                "INSERT INTO pelanggan
                (id, nama, jenis_kelamin, telp, alamat)
                VALUES (?, ?, ?, ?, ?)"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "sssss",
                $id,
                $nama,
                $jenis_kelamin,
                $telp,
                $alamat
            );

            if (mysqli_stmt_execute($stmt)) {
                header("Location: pelanggan.php?pesan=tambah");
                exit;
            } else {
                $error = "Data pelanggan gagal ditambahkan.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pelanggan</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>

<nav>
    <a href="../home/index.php">Home</a>

    <div>
        <span>Data Master</span>
        <div>
            <a href="../barang/barang.php">Data Barang</a>
            <a href="../supplier/supplier.php">Data Supplier</a>
            <a href="pelanggan.php">Data Pelanggan</a>
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

    <h2>Tambah Data Pelanggan</h2>

    <?php if ($error != "") { ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php } ?>

    <form method="POST">

        <label>ID Pelanggan</label>
        <input type="text" name="id"
               placeholder="Contoh: PLG006"
               maxlength="20"
               value="<?= htmlspecialchars($_POST['id'] ?? ''); ?>"
               required>

        <label>Nama Pelanggan</label>
        <input type="text" name="nama"
               placeholder="Masukkan nama pelanggan"
               maxlength="100"
               value="<?= htmlspecialchars($_POST['nama'] ?? ''); ?>"
               required>

        <label>Jenis Kelamin</label>
        <select name="jenis_kelamin" required>
            <option value="">-- Pilih Jenis Kelamin --</option>
            <option value="L"
                <?= ($_POST['jenis_kelamin'] ?? '') == 'L' ? 'selected' : ''; ?>>
                Laki-laki
            </option>
            <option value="P"
                <?= ($_POST['jenis_kelamin'] ?? '') == 'P' ? 'selected' : ''; ?>>
                Perempuan
            </option>
        </select>

        <label>Nomor Telepon</label>
        <input type="text" name="telp"
               placeholder="Masukkan nomor telepon"
               maxlength="12"
               value="<?= htmlspecialchars($_POST['telp'] ?? ''); ?>">

        <label>Alamat</label>
        <textarea name="alamat"
                  placeholder="Masukkan alamat"><?= htmlspecialchars($_POST['alamat'] ?? ''); ?></textarea>

        <button type="submit" name="simpan">Simpan</button>
        <a href="pelanggan.php" class="btn-kembali">Kembali</a>

    </form>

</div>

</body>
</html>
