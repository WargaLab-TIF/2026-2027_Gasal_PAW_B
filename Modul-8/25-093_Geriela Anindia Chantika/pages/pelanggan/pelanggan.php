
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

if (isset($_POST['hapus'])) {
    $id = trim($_POST['id']);

    $stmt = mysqli_prepare(
        $koneksi,
        "DELETE FROM pelanggan WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, "s", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: pelanggan.php?pesan=hapus");
        exit;
    } else {
        $pesan = "Data pelanggan gagal dihapus. Pelanggan mungkin masih digunakan dalam transaksi.";
    }
}

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM pelanggan ORDER BY id ASC"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>

<nav>
    <a href="../home/index.php">Home</a>

    <div>
        <span>Data Master</span>
        <div>
            <a href="../barang/barang.php">Data Barang</a>
            <a href="../supplier/suplier.php">Data Supplier</a>
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

    <h2>Data Pelanggan</h2>

    <a href="tambah_pelanggan.php" class="btn-tambah">
        + Tambah Pelanggan
    </a>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'hapus') { ?>
        <div class="alert">
            Data pelanggan berhasil dihapus.
        </div>
    <?php } ?>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'tambah') { ?>
        <div class="alert">
            Data pelanggan berhasil ditambahkan.
        </div>
    <?php } ?>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'edit') { ?>
        <div class="alert">
            Data pelanggan berhasil diperbarui.
        </div>
    <?php } ?>

    <?php if (isset($pesan)) { ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($pesan); ?>
        </div>
    <?php } ?>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Pelanggan</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $no = 1;
            while ($pelanggan = mysqli_fetch_assoc($query)) :
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($pelanggan['id']); ?></td>
                <td><?= htmlspecialchars($pelanggan['nama']); ?></td>
                <td>
                    <?= $pelanggan['jenis_kelamin'] == 'L'
                        ? 'Laki-laki' : 'Perempuan'; ?>
                </td>
                <td><?= htmlspecialchars($pelanggan['telp'] ?? '-'); ?></td>
                <td><?= htmlspecialchars($pelanggan['alamat'] ?? '-'); ?></td>
                <td>
                    <a href="edit_pelanggan.php?id=<?= urlencode($pelanggan['id']); ?>" class="btn-edit">
                        Edit
                    </a>

                    <form method="POST" action="pelanggan.php"
                          style="display:inline;"
                          onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">

                        <input type="hidden" name="id"
                               value="<?= htmlspecialchars($pelanggan['id']); ?>">

                        <button type="submit" name="hapus" class="btn-hapus">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <br>
    <a href="../home/index.php" class="btn-kembali">Kembali</a>

</div>

</body>
</html>
