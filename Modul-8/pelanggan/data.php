
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['level'] != 1) {
    header("Location: ../index.php");
    exit;
}

require_once '../koneksi.php';

$data = mysqli_query($conn, "SELECT * FROM pelanggan ORDER BY id DESC");

if (!$data) {
    die("Query gagal: " . mysqli_error($conn));
}

include '../navbar.php';
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Data Pelanggan</h4>
        </div>

        <div class="card-body">

            <a href="tambah.php" class="btn btn-success mb-3">
                + Tambah Pelanggan
            </a>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Jenis Kelamin</th>
                            <th>No. Telepon</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;

                        while ($pelanggan = mysqli_fetch_assoc($data)) {
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($pelanggan['nama']); ?></td>
                                <td>
                                    <?= $pelanggan['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?>
                                </td>
                                <td><?= htmlspecialchars($pelanggan['telp']); ?></td>
                                <td><?= htmlspecialchars($pelanggan['alamat']); ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $pelanggan['id']; ?>"
                                       class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <a href="hapus.php?id=<?= $pelanggan['id']; ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>

                        <?php if (mysqli_num_rows($data) == 0) { ?>
                            <tr>
                                <td colspan="6" class="text-center">
                                    Belum ada data pelanggan.
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
</body>
</html>
