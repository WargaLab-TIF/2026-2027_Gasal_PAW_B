
<?php
include "koneksi.php";

$query_transaksi = mysqli_query($conn, "
    SELECT transaksi.*, pelanggan.nama AS nama_pelanggan
    FROM transaksi
    INNER JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
");

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$transaksi = null;

if ($id > 0) {
    $query_master = mysqli_query($conn, "
        SELECT transaksi.*, pelanggan.nama AS nama_pelanggan
        FROM transaksi
        INNER JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
        WHERE transaksi.id = $id
    ");

    $transaksi = mysqli_fetch_assoc($query_master);
}

if ($transaksi) {
    $query_detail = mysqli_query($conn, "
        SELECT
            transaksi_detail.transaksi_id,
            transaksi_detail.barang_id,
            transaksi_detail.harga,
            transaksi_detail.qty,
            barang.nama_barang AS nama_barang
        FROM transaksi_detail
        INNER JOIN barang
        ON transaksi_detail.barang_id = barang.id
        WHERE transaksi_detail.transaksi_id = $id
    ");

    $query_barang = mysqli_query($conn, "
        SELECT * FROM barang
        WHERE id NOT IN (
            SELECT barang_id
            FROM transaksi_detail
            WHERE transaksi_id = $id
        )
    ");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi</title>

    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: whitesmoke;
        margin: 30px;
        color: darkslategray;
    }

    h2, h3 {
        color: cadetblue;
    }

    a {
        display: inline-block;
        background-color: cadetblue;
        color: white;
        text-decoration: none;
        padding: 8px 12px;
        border-radius: 5px;
        margin: 5px;
    }

    a:hover {
        background-color: darkslategray;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        margin-top: 15px;
        margin-bottom: 25px;
    }

    th {
        background-color: lightblue;
    }

    th, td {
        border: 1px solid lightgray;
        padding: 10px;
        text-align: left;
    }

    tr:hover {
        background-color: aliceblue;
    }

    form {
        background-color: white;
        padding: 15px;
        border: 1px solid lightgray;
        border-radius: 5px;
        margin-top: 15px;
    }

    label {
        display: inline-block;
        width: 100px;
        margin-bottom: 12px;
    }

    select, input {
        padding: 8px;
        border: 1px solid silver;
        border-radius: 4px;
        margin-bottom: 10px;
    }

    button {
        background-color: mediumseagreen;
        color: white;
        border: none;
        padding: 9px 15px;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: seagreen;
    }

    button.hapus {
        background-color: crimson;
    }

    button.hapus:hover {
        background-color: darkred;
    }

    .error {
        background-color: mistyrose;
        color: firebrick;
        padding: 10px;
        border-radius: 5px;
    }

    .success {
        background-color: honeydew;
        color: seagreen;
        padding: 10px;
        border-radius: 5px;
    }
    </style>
</head>

<body>

<h2>Data Transaksi</h2>

<a href="index.php">Kembali</a>

<?php
if (isset($_GET['status'])) {
    if (isset($_GET['error'])) {
        echo "<p class='error'>" .
            htmlspecialchars($_GET['status']) .
            "</p>";
    } else {
        echo "<p class='success'>" .
            htmlspecialchars($_GET['status']) .
            "</p>";
    }
}
?>

<h3>Master Transaksi</h3>

<table>
    <tr>
        <th>ID Transaksi</th>
        <th>Tanggal</th>
        <th>Pelanggan</th>
        <th>Total</th>
        <th>Aksi</th>
    </tr>

    <?php while ($data = mysqli_fetch_assoc($query_transaksi)) { ?>
    <tr>
        <td><?= $data['id'] ?></td>
        <td><?= $data['waktu_transaksi'] ?></td>
        <td><?= $data['nama_pelanggan'] ?></td>
        <td><?= $data['total'] ?></td>
        <td>
            <a href="transaksi.php?id=<?= $data['id'] ?>">
                Pilih
            </a>
        </td>
    </tr>
    <?php } ?>
</table>

<?php if ($transaksi) { ?>

<h3>Detail Transaksi</h3>

<p>ID Transaksi: <?= $transaksi['id'] ?></p>

<p>Nama Pelanggan: <?= $transaksi['nama_pelanggan'] ?></p>

<h3>Tambah Detail Barang</h3>

<form action="simpan_detail.php" method="POST">

    <input type="hidden" name="transaksi_id"
           value="<?= $transaksi['id'] ?>">

    <label>Barang</label>

    <select name="barang_id" required>
        <option value="">-- Pilih Barang --</option>

        <?php while ($barang = mysqli_fetch_assoc($query_barang)) { ?>
        <option value="<?= $barang['id'] ?>">
            <?= $barang['nama_barang'] ?>
        </option>
        <?php } ?>
    </select>

    <br><br>

    <label>Jumlah</label>

    <input type="number" name="qty" min="1" required>

    <br><br>

    <button type="submit" class="simpan">
        Simpan Detail
    </button>

</form>

<h3>Daftar Detail Barang</h3>

<table>
    <tr>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
        <th>Aksi</th>
    </tr>

    <?php
    $total = 0;

    while ($data = mysqli_fetch_assoc($query_detail)) {
        $subtotal = $data['harga'] * $data['qty'];
        $total += $subtotal;
    ?>

    <tr>
        <td><?= $data['nama_barang'] ?></td>
        <td><?= $data['harga'] ?></td>
        <td><?= $data['qty'] ?></td>
        <td><?= $subtotal ?></td>
        <td>
            <form action="hapus_detail.php" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus barang ini?')">

                <input type="hidden" name="transaksi_id"
                       value="<?= $data['transaksi_id'] ?>">

                <input type="hidden" name="barang_id"
                       value="<?= $data['barang_id'] ?>">

                <button type="submit" class="hapus">
                    Hapus
                </button>
            </form>
        </td>
    </tr>

    <?php } ?>

    <tr>
        <th colspan="3">Total Transaksi</th>
        <th colspan="2"><?= $transaksi['total'] ?></th>
    </tr>
</table>

<?php
} elseif ($id > 0) {
    echo "<p>Transaksi tidak ditemukan.</p>";
} else {
    echo "<p>Silakan pilih transaksi terlebih dahulu.</p>";
}
?>

</body>
</html>
