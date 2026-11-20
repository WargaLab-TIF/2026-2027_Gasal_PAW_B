<?php
include 'koneksi.php';
wajib_login();
if (isset($_GET['id'])) {


$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$hasil_master = mysqli_query($conn, "SELECT transaksi.*, pelanggan.nama
                                        FROM transaksi
                                        INNER JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
                                        WHERE transaksi.id = $id");
$master = mysqli_fetch_assoc($hasil_master);

if (!$master) {
    die("Transaksi tidak ditemukan. <a href='transaksi.php'>Kembali</a>");
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
            $harga = $barang['harga'] ?? null;
            if ($harga === null) {
                $pesan = 'Barang tidak ditemukan.';
            } else {
            mysqli_query($conn, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty)
                                    VALUES ($id, $barang_id, $harga, $qty)");

            mysqli_query($conn, "UPDATE transaksi
                                    SET total = (SELECT SUM(harga * qty) FROM transaksi_detail
                                                 WHERE transaksi_id = $id)
                                    WHERE id = $id");

            header("Location: transaksi.php?id=$id&sukses=1");
            exit;
            }
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

<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title>Detail Transaksi</title>
</head>
<body>

<?php menu(); ?>

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

<?php exit; } ?>
<?php

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
        header("Location: transaksi.php?id=$id_baru");
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
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title>Data Transaksi</title>
</head>
<body>

<?php menu(); ?>

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
            <td><button type="submit" name="simpan">Simpan</button></td>
        </tr>
    </table>
</form>

<h2>Daftar Transaksi</h2>
<table border="1" cellpadding="6">
    <tr>
        <th >ID</th>
        <th >Tanggal</th>
        <th >Pelanggan</th>
        <th >Keterangan</th>
        <th >Total</th>
        <th >Aksi</th>
    </tr>
    <?php while ($t = mysqli_fetch_assoc($data_transaksi)) { ?>
    <tr>
        <td><?php echo $t['id']; ?></td>
        <td><?php echo $t['waktu_transaksi']; ?></td>
        <td><?php echo htmlspecialchars($t['nama']); ?></td>
        <td><?php echo htmlspecialchars($t['keterangan']); ?></td>
        <td align="right">Rp <?php echo number_format($t['total'], 0, ',', '.'); ?></td>
        <td><a href="transaksi.php?id=<?php echo $t['id']; ?>">Detail</a></td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
