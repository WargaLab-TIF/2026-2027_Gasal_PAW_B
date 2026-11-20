
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

$pesan = "";

if (isset($_POST['hapus'])) {
    $id = (int) $_POST['id'];

    try {
        $stmt = mysqli_prepare(
            $koneksi,
            "DELETE FROM barang WHERE id = ?"
        );

        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        header("Location: barang.php?pesan=hapus");
        exit;

    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1451) {
            $pesan = "Barang tidak dapat dihapus karena masih digunakan dalam transaksi.";
        } else {
            $pesan = "Terjadi kesalahan saat menghapus barang.";
        }
    }
}

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM barang ORDER BY id ASC"
);

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>

<nav>
    <a href="../home/index.php">Home</a>

    <div>
        <span>Data Master</span>
        <div>
            <a href="barang.php">Data Barang</a>
            <a href="../supplier/suplier.php">Data Supplier</a>
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

    <h2>Data Barang</h2>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'tambah') { ?>
        <div class="alert">
            Data barang berhasil ditambahkan.
        </div>
    <?php } ?>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'edit') { ?>
        <div class="alert">
            Data barang berhasil diperbarui.
        </div>
    <?php } ?>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'hapus') { ?>
        <div class="alert">
            Barang berhasil dihapus.
        </div>
    <?php } ?>

    <?php if ($pesan != "") { ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($pesan); ?>
        </div>
    <?php } ?>

    <br>

    <a href="tambah_barang.php" class="btn-tambah">
        + Tambah Barang
    </a>

    <br><br>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $no = 1;

            if (mysqli_num_rows($query) > 0) {
                while ($barang = mysqli_fetch_assoc($query)) {
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($barang['kode_barang']); ?></td>
                    <td><?= htmlspecialchars($barang['nama_barang']); ?></td>
                    <td>
                        Rp <?= number_format($barang['harga'], 0, ',', '.'); ?>
                    </td>
                    <td><?= $barang['stok']; ?></td>
                    <td>
                        <a href="edit_barang.php?id=<?= $barang['id']; ?>"
                           class="btn-edit">
                            Edit
                        </a>

                        <form method="POST"
                              action="barang.php"
                              style="display:inline;"
                              onsubmit="return confirm('Yakin ingin menghapus barang ini?')">

                            <input type="hidden"
                                   name="id"
                                   value="<?= $barang['id']; ?>">

                            <button type="submit"
                                    name="hapus"
                                    class="btn-hapus">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td colspan="6">Belum ada data barang.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <br>

    <a href="../home/index.php" class="btn-kembali">
        Kembali
    </a>

</div>

</body>
</html>
