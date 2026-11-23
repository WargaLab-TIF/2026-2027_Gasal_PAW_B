<?php
include 'koneksi.php';

$pesan = "";

if (isset($_POST['simpan'])) {
    $tanggal      = $_POST['tanggal'];
    $pelanggan_id = $_POST['pelanggan_id'];
    $keterangan   = trim($_POST['keterangan']);

    if (empty($tanggal) || empty($pelanggan_id)) {
        $pesan = "Tanggal dan pelanggan wajib diisi.";
    } else {
        $tanggal      = mysqli_real_escape_string($conn, $tanggal);
        $pelanggan_id = mysqli_real_escape_string($conn, $pelanggan_id);
        $keterangan   = mysqli_real_escape_string($conn, $keterangan);

        mysqli_query($conn, "INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id)
                                VALUES ('$tanggal', '$keterangan', 0, '$pelanggan_id')");

        $id_baru = mysqli_insert_id($conn);
        header("Location: detail.php?id=$id_baru");
        exit;
    }
}

$data_transaksi = mysqli_query($conn, "SELECT transaksi.id, transaksi.waktu_transaksi,
                                                 transaksi.keterangan, transaksi.total, pelanggan.nama
                                          FROM transaksi
                                          INNER JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
                                          ORDER BY transaksi.id DESC");

$data_pelanggan = mysqli_query($conn, "SELECT id, nama FROM pelanggan");
?>
<html>
<head>
    <title>Data Transaksi</title>
</head>
<body>

<a href="index.php">Transaksi</a> | <a href="barang.php">Barang</a>
<hr>

<?php if ($pesan != "") { ?>
    <p><b><?php echo $pesan; ?></b></p>
<?php } ?>

<h2>Tambah Transaksi</h2>
<form method="post">
    <table border="1" cellpadding="6">
        <tr>
            <td>Tanggal</td>
            <td><input type="date" name="tanggal" value="<?php echo date('Y-m-d'); ?>"></td>
        </tr>
        <tr>
            <td>Pelanggan</td>
            <td>
                <select name="pelanggan_id">
                    <option value="">Pilih Pelanggan</option>
                    <?php while ($p = mysqli_fetch_assoc($data_pelanggan)) { ?>
                        <option value="<?php echo htmlspecialchars($p['id']); ?>">
                            <?php echo htmlspecialchars($p['id'] . " - " . $p['nama']); ?>
                        </option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td><textarea name="keterangan" rows="2" cols="30"></textarea></td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit" name="simpan">Simpan</td>
        </tr>
    </table>
</form>

<h2>Daftar Transaksi</h2>
<table border="1" cellpadding="6">
    <tr>
        <th style="background-color: slateblue; color: white;">ID</th>
        <th style="background-color: slateblue; color: white;">Tanggal</th>
        <th style="background-color: slateblue; color: white;">Pelanggan</th>
        <th style="background-color: slateblue; color: white;">Keterangan</th>
        <th style="background-color: slateblue; color: white;">Total</th>
        <th style="background-color: slateblue; color: white;">Aksi</th>
    </tr>
    <?php while ($t = mysqli_fetch_assoc($data_transaksi)) { ?>
    <tr>
        <td><?php echo $t['id']; ?></td>
        <td><?php echo $t['waktu_transaksi']; ?></td>
        <td><?php echo htmlspecialchars($t['nama']); ?></td>
        <td><?php echo htmlspecialchars($t['keterangan']); ?></td>
        <td align="right">Rp <?php echo number_format($t['total'], 0, ',', '.'); ?></td>
        <td><a href="detail.php?id=<?php echo $t['id']; ?>">Detail</a></td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
