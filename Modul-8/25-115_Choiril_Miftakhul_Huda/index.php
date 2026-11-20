<?php
require "fungsi.php";

if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

$halaman = $_GET["halaman"] ?? "beranda";

if (in_array($halaman, ["master", "barang", "supplier", "pelanggan", "user"])) {
    cekOwner();
}

if ($halaman === "detail") {
    $id = (int) ($_GET["id"] ?? 0);
    $transaksi = select_transaksi($id);

    if (!$transaksi) {
        header("Location: index.php?halaman=transaksi");
        exit();
    }

    if (isset($_POST["submit"])) {
        tambah_detail($id, $_POST["barang_id"] ?? 0, $_POST["qty"] ?? 0);
        header("Location: index.php?halaman=detail&id=" . $id);
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Utama</title>
</head>
<body>

    <table width="100%">
        <tr>
            <td>
                <a href="index.php">Home</a> |
                <?php if ($_SESSION["level"] == 1) { ?>
                    <a href="index.php?halaman=master">Data Master</a> |
                <?php } ?>
                <a href="index.php?halaman=transaksi">Transaksi</a> |
                <a href="index.php?halaman=laporan">Laporan</a>
            </td>
            <td align="right">
                <?= htmlspecialchars($_SESSION["username"]) ?>
                <form action="" method="post">
                    <button type="submit" name="logout" value="logout">Logout</button>
                </form>
            </td>
        </tr>
    </table>
    <hr>

    <?php if ($halaman === "master") : ?>
        <h1>Data Master</h1>
        <ul>
            <li><a href="index.php?halaman=barang">Data Barang</a></li>
            <li><a href="index.php?halaman=supplier">Data Supplier</a></li>
            <li><a href="index.php?halaman=pelanggan">Data Pelanggan</a></li>
            <li><a href="index.php?halaman=user">Data User</a></li>
        </ul>

    <?php elseif ($halaman === "barang") : ?>
        <?php $data = getBarangWithSupplier(); ?>
        <h1>Data Barang</h1>
        <a href="tambah.php?tabel=barang">+ Tambah barang</a>
        <br><br>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Kode</th>
                <th>Nama barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Supplier</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($data as $row) : ?>
            <tr>
                <td><?= htmlspecialchars($row["kode_barang"]) ?></td>
                <td><?= htmlspecialchars($row["nama_barang"]) ?></td>
                <td><?= htmlspecialchars($row["harga"]) ?></td>
                <td><?= htmlspecialchars($row["stok"]) ?></td>
                <td><?= htmlspecialchars($row["nama_supplier"]) ?></td>
                <td>
                    <a href="edit.php?tabel=barang&id=<?= $row["id"] ?>">Edit</a> |
                    <a href="hapus.php?tabel=barang&id=<?= $row["id"] ?>" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

    <?php elseif ($halaman === "supplier") : ?>
        <?php $data = getSupplier(); ?>
        <h1>Data Supplier</h1>
        <a href="tambah.php?tabel=supplier">+ Tambah supplier</a>
        <br><br>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Nama</th>
                <th>Telp</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($data as $row) : ?>
            <tr>
                <td><?= htmlspecialchars($row["nama"]) ?></td>
                <td><?= htmlspecialchars($row["telp"]) ?></td>
                <td><?= htmlspecialchars($row["alamat"]) ?></td>
                <td>
                    <a href="edit.php?tabel=supplier&id=<?= $row["id"] ?>">Edit</a> |
                    <a href="hapus.php?tabel=supplier&id=<?= $row["id"] ?>" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

    <?php elseif ($halaman === "pelanggan") : ?>
        <?php $data = getPelanggan(); ?>
        <h1>Data Pelanggan</h1>
        <a href="tambah.php?tabel=pelanggan">+ Tambah pelanggan</a>
        <br><br>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>JK</th>
                <th>Telp</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($data as $row) : ?>
            <tr>
                <td><?= htmlspecialchars($row["id"]) ?></td>
                <td><?= htmlspecialchars($row["nama"]) ?></td>
                <td><?= htmlspecialchars($row["jenis_kelamin"]) ?></td>
                <td><?= htmlspecialchars($row["telp"]) ?></td>
                <td><?= htmlspecialchars($row["alamat"]) ?></td>
                <td>
                    <a href="edit.php?tabel=pelanggan&id=<?= urlencode($row["id"]) ?>">Edit</a> |
                    <a href="hapus.php?tabel=pelanggan&id=<?= urlencode($row["id"]) ?>" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

    <?php elseif ($halaman === "user") : ?>
        <?php $data = getUser(); ?>
        <h1>Data User</h1>
        <a href="tambah.php?tabel=user">+ Tambah user</a>
        <br><br>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Username</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>HP</th>
                <th>Level</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($data as $row) : ?>
            <tr>
                <td><?= htmlspecialchars($row["username"]) ?></td>
                <td><?= htmlspecialchars($row["nama"]) ?></td>
                <td><?= htmlspecialchars($row["alamat"]) ?></td>
                <td><?= htmlspecialchars($row["hp"]) ?></td>
                <td><?= $row["level"] == 1 ? "Owner" : "Kasir" ?></td>
                <td>
                    <a href="edit.php?tabel=user&id=<?= $row["id_user"] ?>">Edit</a> |
                    <a href="hapus.php?tabel=user&id=<?= $row["id_user"] ?>" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

    <?php elseif ($halaman === "transaksi") : ?>
        <?php $data = getTransaksi(); ?>
        <h1>Data Transaksi</h1>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Waktu</th>
                <th>Keterangan</th>
                <th>Total</th>
                <th>Pelanggan</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($data as $row) : ?>
            <tr>
                <td><?= $row["id"] ?></td>
                <td><?= htmlspecialchars($row["waktu_transaksi"]) ?></td>
                <td><?= htmlspecialchars($row["keterangan"]) ?></td>
                <td><?= htmlspecialchars($row["total"]) ?></td>
                <td><?= htmlspecialchars($row["pelanggan_id"]) ?></td>
                <td>
                    <a href="index.php?halaman=detail&id=<?= $row["id"] ?>">Detail</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

    <?php elseif ($halaman === "detail") : ?>
        <?php
        $details = getDetailTransaksi($id);
        $barangs = getBarangBelumDipakai($id);
        ?>
        <h1>Detail Transaksi</h1>
        <a href="index.php?halaman=transaksi">Kembali</a>

        <h3>Master</h3>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr><td>ID</td><td><?= $transaksi["id"] ?></td></tr>
            <tr><td>Waktu</td><td><?= htmlspecialchars($transaksi["waktu_transaksi"]) ?></td></tr>
            <tr><td>Keterangan</td><td><?= htmlspecialchars($transaksi["keterangan"]) ?></td></tr>
            <tr><td>Pelanggan</td><td><?= htmlspecialchars($transaksi["pelanggan_id"]) ?></td></tr>
            <tr><td>Total</td><td><?= htmlspecialchars($transaksi["total"]) ?></td></tr>
        </table>

        <h3>Detail</h3>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Barang</th>
                <th>Harga</th>
                <th>Qty</th>
            </tr>
            <?php foreach ($details as $row) : ?>
            <tr>
                <td><?= htmlspecialchars($row["nama_barang"]) ?></td>
                <td><?= htmlspecialchars($row["harga"]) ?></td>
                <td><?= htmlspecialchars($row["qty"]) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <h3>Tambah Barang</h3>
        <form action="" method="post">
            <select name="barang_id">
                <?php foreach ($barangs as $barang) : ?>
                    <option value="<?= $barang["id"] ?>"><?= htmlspecialchars($barang["nama_barang"]) ?></option>
                <?php endforeach; ?>
            </select>
            Qty: <input type="number" name="qty" value="1" min="1">
            <button type="submit" name="submit">Kirim</button>
        </form>

    <?php elseif ($halaman === "laporan") : ?>
        <?php
        $data = getLaporan();
        $total = 0;
        ?>
        <h1>Laporan Penjualan per Barang</h1>
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>Kode</th>
                <th>Nama barang</th>
                <th>Jumlah terjual</th>
                <th>Pendapatan</th>
            </tr>
            <?php foreach ($data as $row) : ?>
            <?php $total += $row["pendapatan"]; ?>
            <tr>
                <td><?= htmlspecialchars($row["kode_barang"]) ?></td>
                <td><?= htmlspecialchars($row["nama_barang"]) ?></td>
                <td><?= $row["jumlah"] ?></td>
                <td><?= $row["pendapatan"] ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3"><b>Total pendapatan</b></td>
                <td><b><?= $total ?></b></td>
            </tr>
        </table>

    <?php else : ?>
        <h1>Selamat datang di penjualan</h1>
    <?php endif; ?>
</body>
</html>
