
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
    $id = (int) $_POST['id'];

    $stmt = mysqli_prepare(
        $koneksi,
        "DELETE FROM supplier WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: suplier.php?pesan=hapus");
        exit;
    } else {
        $pesan = "Data supplier gagal dihapus. Supplier mungkin masih digunakan oleh barang.";
    }
}

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM supplier ORDER BY id ASC"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Supplier</title>
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

    <h2>Data Supplier</h2>

    <a href="tambah_suplier.php" class="btn-tambah">
        + Tambah Supplier
    </a>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'hapus') { ?>
        <div class="alert">
            Data supplier berhasil dihapus.
        </div>
    <?php } ?>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'tambah') { ?>
        <div class="alert">
            Data supplier berhasil ditambahkan.
        </div>
    <?php } ?>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'edit') { ?>
        <div class="alert">
            Data supplier berhasil diperbarui.
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
                <th>ID Supplier</th>
                <th>Nama Supplier</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $no = 1;
            while ($supplier = mysqli_fetch_assoc($query)) :
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $supplier['id']; ?></td>
                <td><?= htmlspecialchars($supplier['nama']); ?></td>
                <td><?= htmlspecialchars($supplier['telp'] ?? '-'); ?></td>
                <td><?= htmlspecialchars($supplier['alamat'] ?? '-'); ?></td>
                <td>
                    <a href="edit_suplier.php?id=<?= $supplier['id']; ?>" class="btn-edit">
                        Edit
                    </a>

                    <form method="POST" action="suplier.php"
                          style="display:inline;"
                          onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">

                        <input type="hidden" name="id"
                               value="<?= $supplier['id']; ?>">

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
