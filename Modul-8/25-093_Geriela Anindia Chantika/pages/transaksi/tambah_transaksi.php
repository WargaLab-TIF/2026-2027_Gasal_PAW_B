
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../../auth/login.php");
    exit;
}

require_once "../../config/koneksi.php";

$error = "";

if (isset($_POST['simpan'])) {
    $tanggal = $_POST['waktu_transaksi'];
    $pelanggan_id = $_POST['pelanggan_id'];
    $keterangan = trim($_POST['keterangan']);

    if ($tanggal == "" || $pelanggan_id == "") {
        $error = "Tanggal dan pelanggan wajib dipilih.";
    } else {
        $stmt = mysqli_prepare(
            $koneksi,
            "INSERT INTO transaksi
            (waktu_transaksi, keterangan, total, pelanggan_id)
            VALUES (?, ?, 0, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sss",
            $tanggal,
            $keterangan,
            $pelanggan_id
        );

        if (mysqli_stmt_execute($stmt)) {
            $id_transaksi = mysqli_insert_id($koneksi);

            header("Location: detail_transaksi.php?id=" . $id_transaksi);
            exit;
        } else {
            $error = "Transaksi gagal ditambahkan: " . mysqli_stmt_error($stmt);
        }
    }
}

$query_pelanggan = mysqli_query(
    $koneksi,
    "SELECT id, nama FROM pelanggan ORDER BY nama ASC"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>

<nav>
    <a href="../home/index.php">Home</a>

    <?php if ($_SESSION['role'] == 'owner') { ?>
    <div>
        <span>Data Master</span>
        <div>
            <a href="../barang/barang.php">Data Barang</a>
            <a href="../supplier/suplier.php">Data Supplier</a>
            <a href="../pelanggan/pelanggan.php">Data Pelanggan</a>
            <a href="../user/user.php">Data User</a>
        </div>
    </div>
    <?php } ?>

    <a href="transaksi.php">Transaksi</a>
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

    <h2>Tambah Transaksi</h2>

    <?php if ($error != "") { ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php } ?>

    <?php if (mysqli_num_rows($query_pelanggan) > 0) { ?>

    <form method="POST">

        <label>Tanggal Transaksi</label>
        <input
            type="date"
            name="waktu_transaksi"
            value="<?= htmlspecialchars($_POST['waktu_transaksi'] ?? date('Y-m-d')); ?>"
            required
        >

        <label>Pelanggan</label>
        <select name="pelanggan_id" required>
            <option value="">-- Pilih Pelanggan --</option>

            <?php while ($pelanggan = mysqli_fetch_assoc($query_pelanggan)) { ?>
                <option
                    value="<?= htmlspecialchars($pelanggan['id']); ?>"
                    <?= (($_POST['pelanggan_id'] ?? '') == $pelanggan['id']) ? 'selected' : ''; ?>
                >
                    <?= htmlspecialchars($pelanggan['nama']); ?>
                </option>
            <?php } ?>
        </select>

        <label>Keterangan</label>
        <textarea name="keterangan" rows="4"><?= htmlspecialchars($_POST['keterangan'] ?? ''); ?></textarea>

        <br><br>

        <button type="submit" name="simpan" class="btn">
            Simpan Transaksi
        </button>

        <a href="transaksi.php" class="btn-kembali">
            Kembali
        </a>

    </form>

    <?php } else { ?>

        <div class="alert alert-error">
            Belum ada data pelanggan. Tambahkan pelanggan terlebih dahulu.
        </div>

        <a href="transaksi.php" class="btn-kembali">Kembali</a>

    <?php } ?>

</div>

</body>
</html>
