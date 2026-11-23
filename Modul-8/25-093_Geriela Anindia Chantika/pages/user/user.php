
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
    $id_user = (int) $_POST['id_user'];

    if ($id_user == $_SESSION['id_user']) {
        $pesan = "Akun yang sedang digunakan tidak dapat dihapus.";
    } else {
        $stmt = mysqli_prepare(
            $koneksi,
            "DELETE FROM user WHERE id_user = ?"
        );

        mysqli_stmt_bind_param($stmt, "i", $id_user);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: user.php?pesan=hapus");
            exit;
        } else {
            $pesan = "Data user gagal dihapus.";
        }
    }
}

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM user ORDER BY id_user ASC"
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
    <title>Data User</title>
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
            <a href="user.php">Data User</a>
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

    <h2>Data User</h2>

    <a href="tambah_user.php" class="btn-tambah">
        + Tambah User
    </a>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'tambah') { ?>
        <div class="alert">
            User berhasil ditambahkan.
        </div>
    <?php } ?>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'edit') { ?>
        <div class="alert">
            User berhasil diperbarui.
        </div>
    <?php } ?>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'hapus') { ?>
        <div class="alert">
            Data user berhasil dihapus.
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
                <th>Nama</th>
                <th>Username</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $no = 1;

            if (mysqli_num_rows($query) > 0) {
                while ($data = mysqli_fetch_assoc($query)) {
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($data['nama']); ?></td>
                    <td><?= htmlspecialchars($data['username']); ?></td>
                    <td><?= ucfirst($data['role']); ?></td>
                    <td>
                        <a href="edit_user.php?id=<?= $data['id_user']; ?>" class="btn-edit">
                            Edit
                        </a>

                        <?php if ($data['id_user'] != $_SESSION['id_user']) { ?>
                            <form method="POST" action="user.php"
                                  style="display:inline;"
                                  onsubmit="return confirm('Yakin ingin menghapus user ini?')">

                                <input type="hidden" name="id_user"
                                       value="<?= $data['id_user']; ?>">

                                <button type="submit" name="hapus" class="btn-hapus">
                                    Hapus
                                </button>
                            </form>
                        <?php } ?>
                    </td>
                </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td colspan="5">Belum ada data user.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <br>

    <a href="../home/index.php" class="btn-kembali">Kembali</a>

</div>

</body>
</html>
