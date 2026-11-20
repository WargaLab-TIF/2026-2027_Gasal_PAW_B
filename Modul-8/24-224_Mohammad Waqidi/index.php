<?php
require_once "midlewire.php";
cek_login("");
require_once "koneksi.php";

$judul = "Home";
include "header.php";
?>

<h2>Home</h2>
<p>Selamat datang, <b><?= htmlspecialchars($_SESSION['nama'] ?? $_SESSION['username']) ?></b>.</p>

<?php if ((int)($_SESSION['level'] ?? 0) === 1) { ?>

<h2 id="data-master">Data Master</h2>

<h3>Data Barang</h3>
<?php
$barang = mysqli_query($koneksi, "SELECT b.*, s.nama AS supplier FROM barang b LEFT JOIN supplier s ON b.supplier_id = s.id ORDER BY b.id");
?>
<table>
    <tr>
        <th>ID</th><th>Kode Barang</th><th>Nama Barang</th><th>Harga</th><th>Stok</th><th>Supplier</th>
    </tr>
    <?php while ($r = mysqli_fetch_assoc($barang)) { ?>
    <tr>
        <td><?= htmlspecialchars($r['id']) ?></td>
        <td><?= htmlspecialchars($r['kode_barang']) ?></td>
        <td><?= htmlspecialchars($r['nama_barang']) ?></td>
        <td>Rp <?= number_format($r['harga']) ?></td>
        <td><?= htmlspecialchars($r['stok']) ?></td>
        <td><?= htmlspecialchars($r['supplier'] ?? '-') ?></td>
    </tr>
    <?php } ?>
</table>

<h3>Data Supplier</h3>
<?php $supplier = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY id"); ?>
<table>
    <tr><th>ID</th><th>Nama Supplier</th><th>Telepon</th><th>Alamat</th></tr>
    <?php while ($r = mysqli_fetch_assoc($supplier)) { ?>
    <tr>
        <td><?= htmlspecialchars($r['id']) ?></td>
        <td><?= htmlspecialchars($r['nama']) ?></td>
        <td><?= htmlspecialchars($r['telp']) ?></td>
        <td><?= htmlspecialchars($r['alamat']) ?></td>
    </tr>
    <?php } ?>
</table>

<h3>Data Pelanggan</h3>
<?php $pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan ORDER BY id"); ?>
<table>
    <tr><th>ID Pelanggan</th><th>Nama</th><th>Jenis Kelamin</th><th>Telepon</th><th>Alamat</th></tr>
    <?php while ($r = mysqli_fetch_assoc($pelanggan)) { ?>
    <tr>
        <td><?= htmlspecialchars($r['id']) ?></td>
        <td><?= htmlspecialchars($r['nama']) ?></td>
        <td><?= htmlspecialchars($r['jenis_kelamin']) ?></td>
        <td><?= htmlspecialchars($r['telp']) ?></td>
        <td><?= htmlspecialchars($r['alamat']) ?></td>
    </tr>
    <?php } ?>
</table>

<h3>Data User</h3>
<?php $user = mysqli_query($koneksi, "SELECT id_user, username, nama, alamat, hp, level FROM user ORDER BY id_user"); ?>
<table>
    <tr><th>ID User</th><th>Username</th><th>Nama</th><th>Alamat</th><th>HP</th><th>Level</th></tr>
    <?php while ($r = mysqli_fetch_assoc($user)) { ?>
    <tr>
        <td><?= htmlspecialchars($r['id_user']) ?></td>
        <td><?= htmlspecialchars($r['username']) ?></td>
        <td><?= htmlspecialchars($r['nama']) ?></td>
        <td><?= htmlspecialchars($r['alamat']) ?></td>
        <td><?= htmlspecialchars($r['hp']) ?></td>
        <td><?= ((int)$r['level'] === 1) ? 'Owner' : (((int)$r['level'] === 2) ? 'Kasir' : htmlspecialchars($r['level'])) ?></td>
    </tr>
    <?php } ?>
</table>

<?php } ?>

<?php include "footer.php"; ?>
