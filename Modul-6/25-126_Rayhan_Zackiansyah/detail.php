<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$hasil_master = mysqli_query($conn, "SELECT transaksi.*, pelanggan.nama
                                        FROM transaksi
                                        INNER JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
                                        WHERE transaksi.id = $id");
$master = mysqli_fetch_assoc($hasil_master);

if (!$master) {
    die("Transaksi tidak ditemukan. <a href='index.php'>Kembali</a>");
}

$pesan = "";

if (isset($_GET['sukses'])) {
    $pesan = "Detail berhasil disimpan, total sudah diperbarui.";
}

if (isset($_POST['simpan'])) {
    $barang_id = (int) $_POST['barang_id'];
    $qty       = (int) $_POST['qty'];

    if ($barang_id < 1 || $qty < 1) {
        $pesan = "Pilih barang dan isi qty minimal 1.";
    } else {
        $cek = mysqli_query($conn, "SELECT * FROM transaksi_detail
                                       WHERE transaksi_id = $id AND barang_id = $barang_id");

        if (mysqli_num_rows($cek) > 0) {
            $pesan = "Barang ini sudah ada di transaksi ini.";
        } else {
            $hasil_barang = mysqli_query($conn, "SELECT harga FROM barang WHERE id = $barang_id");
            $barang = mysqli_fetch_assoc($hasil_barang);
            $harga = $barang['harga'];

            mysqli_query($conn, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty)
                                    VALUES ($id, $barang_id, $harga, $qty)");

            mysqli_query($conn, "UPDATE transaksi
                                    SET total = (SELECT SUM(harga * qty) FROM transaksi_detail
                                                 WHERE transaksi_id = $id)
                                    WHERE id = $id");

            header("Location: detail.php?id=$id&sukses=1");
            exit;
        }
    }
}

$data_detail = mysqli_query($conn, "SELECT barang.kode_barang, barang.nama_barang,
                                              transaksi_detail.harga, transaksi_detail.qty
                                       FROM transaksi_detail
                                       INNER JOIN barang ON transaksi_detail.barang_id = barang.id
                                       WHERE transaksi_detail.transaksi_id = $id");

$data_barang = mysqli_query($conn, "SELECT * FROM barang
                                       WHERE id NOT IN (SELECT barang_id FROM transaksi_detail
                                                        WHERE transaksi_id = $id)");
?>
<html>
<head>
    <title>Detail Transaksi</title>
</head>
<body>

<a href="index.php">Transaksi</a> | <a href="barang.php">Barang</a>
<hr>

<?php if ($pesan != "") { ?>
    <p><b><?php echo $pesan; ?></b></p>
<?php } ?>

<h2>Transaksi #<?php echo $master['id']; ?></h2>
<table border="1" cellpadding="6">
    <tr><td>Tanggal</td><td><?php echo $master['waktu_transaksi']; ?></td></tr>
    <tr><td>Pelanggan</td><td><?php echo htmlspecialchars($master['nama']); ?></td></tr>
    <tr><td>Keterangan</td><td><?php echo htmlspecialchars($master['keterangan']); ?></td></tr>
    <tr><td>Total</td><td><b>Rp <?php echo number_format($master['total'], 0, ',', '.'); ?></b></td></tr>
</table>

<h2>Detail Barang</h2>
<table border="1" cellpadding="6">
    <tr>
        <th>Kode</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Qty</th>
        <th>Subtotal</th>
    </tr>
    <?php while ($d = mysqli_fetch_assoc($data_detail)) { ?>
    <tr>
        <td><?php echo htmlspecialchars($d['kode_barang']); ?></td>
        <td><?php echo htmlspecialchars($d['nama_barang']); ?></td>
        <td align="right"><?php echo number_format($d['harga'], 0, ',', '.'); ?></td>
        <td align="right"><?php echo $d['qty']; ?></td>
        <td align="right"><?php echo number_format($d['harga'] * $d['qty'], 0, ',', '.'); ?></td>
    </tr>
    <?php } ?>
</table>

<h2>Tambah Barang</h2>
<form method="post">
    <table border="1" cellpadding="6">
        <tr>
            <td>Barang</td>
            <td>
                <select name="barang_id">
                    <option value="">-- Pilih Barang --</option>
                    <?php while ($b = mysqli_fetch_assoc($data_barang)) { ?>
                        <option value="<?php echo $b['id']; ?>">
                            <?php echo htmlspecialchars($b['kode_barang'] . " - " . $b['nama_barang']) . " (Rp " . number_format($b['harga'], 0, ',', '.') . ")"; ?>
                        </option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Qty</td>
            <td><input type="number" name="qty" value="1" min="1"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="simpan" value="Simpan Detail"></td>
        </tr>
    </table>
</form>

</body>
</html>
