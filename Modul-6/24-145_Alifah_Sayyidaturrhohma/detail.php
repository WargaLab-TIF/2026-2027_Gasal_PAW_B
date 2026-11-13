<?php
include "koneksi.php";

$id = $_GET['id'];

$query_transaksi = mysqli_query($conn, "SELECT transaksi.*, pelanggan.nama 
FROM transaksi 
JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id 
WHERE transaksi.id = '$id'");

$transaksi = mysqli_fetch_assoc($query_transaksi);

if (isset($_POST['tambah'])) {
    $barang_id = $_POST['barang_id'];
    $qty = $_POST['qty'];

    $ambil_barang = mysqli_query($conn, "SELECT * FROM barang WHERE id = '$barang_id'");
    $data_barang = mysqli_fetch_assoc($ambil_barang);
    $harga = $data_barang['harga'];

    $insert = mysqli_query($conn, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) 
    VALUES ('$id', '$barang_id', '$harga', '$qty')");

    if ($insert) {
        $hitung_total = mysqli_query($conn, "SELECT SUM(harga * qty) AS total_baru 
        FROM transaksi_detail 
        WHERE transaksi_id = '$id'");
        $data_total = mysqli_fetch_assoc($hitung_total);
        $total_baru = $data_total['total_baru'];

        mysqli_query($conn, "UPDATE transaksi SET total = '$total_baru' WHERE id = '$id'");

        header("Location: detail.php?id=$id");
        exit;
    }
}

$query_detail = mysqli_query($conn, "SELECT transaksi_detail.*, barang.nama_barang 
FROM transaksi_detail 
JOIN barang ON transaksi_detail.barang_id = barang.id 
WHERE transaksi_detail.transaksi_id = '$id'");

$barang_dibeli = [];
$cek_detail = mysqli_query($conn, "SELECT barang_id FROM transaksi_detail WHERE transaksi_id = '$id'");
while ($row = mysqli_fetch_assoc($cek_detail)) {
    $barang_dibeli[] = $row['barang_id'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Transaksi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Detail Transaksi</h2>
    <a href="index.php">Kembali ke Data Transaksi</a>
    <br><br>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID Transaksi</th>
            <td><?php echo $transaksi['id']; ?></td>
        </tr>
        <tr>
            <th>Waktu Transaksi</th>
            <td><?php echo $transaksi['waktu_transaksi']; ?></td>
        </tr>
        <tr>
            <th>Nama Pelanggan</th>
            <td><?php echo $transaksi['nama']; ?></td>
        </tr>
        <tr>
            <th>Keterangan</th>
            <td><?php echo $transaksi['keterangan']; ?></td>
        </tr>
        <tr>
            <th>Total Transaksi</th>
            <td><?php echo $transaksi['total']; ?></td>
        </tr>
    </table>

    <br>

    <h3>Tambah Barang</h3>
    <form method="POST">
        <label>Pilih Barang :</label>
        <select name="barang_id" required>
            <option value="">-- Pilih Barang --</option>
            <?php
            $query_barang = mysqli_query($conn, "SELECT * FROM barang");
            while ($b = mysqli_fetch_assoc($query_barang)) {
                if (in_array($b['id'], $barang_dibeli)) {
                    echo "<option value='" . $b['id'] . "' disabled>" . $b['nama_barang'] . " (Sudah dipilih)</option>";
                } else {
                    echo "<option value='" . $b['id'] . "'>" . $b['nama_barang'] . "</option>";
                }
            }
            ?>
        </select>

        <label>Qty :</label>
        <input type="number" name="qty" min="1" value="1" required>

        <button type="submit" name="tambah">Tambah</button>
    </form>

    <br>

    <h3>Daftar Barang</h3>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>

        <?php
        $no = 1;
        while ($detail = mysqli_fetch_assoc($query_detail)) {
            $subtotal = $detail['harga'] * $detail['qty'];
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $detail['nama_barang']; ?></td>
            <td><?php echo $detail['harga']; ?></td>
            <td><?php echo $detail['qty']; ?></td>
            <td><?php echo $subtotal; ?></td>
        </tr>
        <?php } ?>
    </table>

</body>
</html>
