<?php
include '../koneksi.php';
cek_login();
if ($_SESSION['level'] != 1) {
    echo "<script>alert('Akses ditolak!'); window.location='../index.php';</script>";
    exit;
}

$hasil = mysqli_query($conn, "SELECT b.*, s.nama AS nama_supplier 
                              FROM barang b 
                              LEFT JOIN supplier s ON b.supplier_id = s.id 
                              ORDER BY b.id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f5f6fa; }
        .container { padding: 20px 30px; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; }
        th { background: #2c3e50; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        .btn { padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 13px; color: white; }
        .btn-tambah { background: #27ae60; margin-bottom: 15px; display: inline-block; }
        .btn-edit { background: #3498db; }
        .btn-hapus { background: #e74c3c; }
        h2 { color: #2c3e50; }
    </style>
</head>
<body>
    <?php include '../navbar.php'; ?>
    <div class="container">
        <h2>Data Barang</h2>
        <a href="tambah.php" class="btn btn-tambah">+ Tambah Barang</a>
        <table>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Supplier</th>
                <th>Aksi</th>
            </tr>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($hasil)) {
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['kode_barang']) ?></td>
                <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td><?= $row['stok'] ?></td>
                <td><?= htmlspecialchars($row['nama_supplier'] ?? '-') ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                    <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-hapus" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
