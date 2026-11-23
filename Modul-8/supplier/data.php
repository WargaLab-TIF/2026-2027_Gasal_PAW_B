
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

$data = mysqli_query($conn, "SELECT * FROM supplier ORDER BY id DESC");

if (!$data) {
    die("Query gagal: " . mysqli_error($conn));
}

include '../navbar.php';
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Data Supplier</h4>
        </div>

        <div class="card-body">

            <a href="tambah.php" class="btn btn-success mb-3">
                + Tambah Supplier
            </a>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Supplier</th>
                            <th>No. Telepon</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;

                        while ($supplier = mysqli_fetch_assoc($data)) {
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($supplier['nama']); ?></td>
                                <td><?= htmlspecialchars($supplier['telp']); ?></td>
                                <td><?= htmlspecialchars($supplier['alamat']); ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $supplier['id']; ?>"
                                       class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <a href="hapus.php?id=<?= $supplier['id']; ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Yakin ingin menghapus supplier ini?')">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>

                        <?php if (mysqli_num_rows($data) == 0) { ?>
                            <tr>
                                <td colspan="5" class="text-center">
                                    Belum ada data supplier.
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
