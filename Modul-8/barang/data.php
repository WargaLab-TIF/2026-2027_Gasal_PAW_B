
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

$data = mysqli_query($conn, "SELECT barang.*, supplier.nama AS supplier_nama
    FROM barang
    LEFT JOIN supplier ON barang.supplier_id = supplier.id
    ORDER BY barang.id DESC");

if (!$data) {
    die("Query gagal: " . mysqli_error($conn));
}

include '../navbar.php';
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Data Barang</h4>
        </div>

        <div class="card-body">

            <a href="tambah.php" class="btn btn-success mb-3">
                + Tambah Barang
            </a>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Supplier</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;

                        while ($barang = mysqli_fetch_assoc($data)) {
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($barang['kode_barang']); ?></td>
                                <td><?= htmlspecialchars($barang['nama_barang']); ?></td>
                                <td>Rp <?= number_format($barang['harga'], 0, ',', '.'); ?></td>
                                <td><?= $barang['stok']; ?></td>
                                <td><?= htmlspecialchars($barang['supplier_nama'] ?? '-'); ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $barang['id']; ?>"
                                       class="btn btn-warning btn-sm">Edit</a>

                                    <a href="hapus.php?id=<?= $barang['id']; ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Yakin ingin menghapus barang ini?')">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>

                        <?php if (mysqli_num_rows($data) == 0) { ?>
                            <tr>
                                <td colspan="7" class="text-center">
                                    Belum ada data barang.
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
