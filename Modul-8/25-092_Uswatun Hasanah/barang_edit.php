<?php
include 'koneksi.php';
include 'auth.php';
cekOwner();

$id = (int)$_GET['id'];

$data = mysqli_query($conn, "SELECT * FROM barang WHERE id='$id'");
$b = mysqli_fetch_assoc($data);

if (!$b) {
    die("Data barang tidak ditemukan.");
}

$supplier = mysqli_query($conn, "SELECT * FROM supplier");

if (isset($_POST['simpan'])) {
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga = preg_replace('/[^0-9]/', '', $_POST['harga']);

    $stok = $_POST['stok'];
    $supplier_id = $_POST['supplier_id'];

    mysqli_query($conn, "UPDATE barang SET
        kode_barang='$kode_barang',
        nama_barang='$nama_barang',
        harga='$harga',
        stok='$stok',
        supplier_id='$supplier_id'
        WHERE id='$id'");

    header("Location: barang.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>

    <style>
        body {
            background: #fff5f8;
            font-family: Arial;
            color: #444;
            margin: 30px;
            line-height: 1.6;
        }

        h2 {
            color: #d63384;
        }

        .container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            max-width: 500px;
            margin: 30px auto;
            box-shadow: 0 2px 8px #f5d5e3;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            border: 1px solid #edb5cd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button, .btn {
            background: #e879a9;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            display: inline-block;
        }

        button:hover, .btn:hover {
            background: #d63384;
        }
    </style>
</head>

<body>

<div class="container">
    <h2>Edit Barang</h2>

    <form method="POST">

        <label>Kode Barang</label>
        <input type="text" name="kode_barang"
            value="<?= htmlspecialchars($b['kode_barang']) ?>" required>

        <label>Nama Barang</label>
        <input type="text" name="nama_barang"
            value="<?= htmlspecialchars($b['nama_barang']) ?>" required>

        <label>Harga</label>
        <input type="text" name="harga"
            value="Rp <?= number_format($b['harga'], 0, ',', '.') ?>" required>

        <label>Stok</label>
        <input type="number" name="stok"
            value="<?= htmlspecialchars($b['stok']) ?>" required>

        <label>Supplier</label>
        <select name="supplier_id" required>
            <option value="">Pilih Supplier</option>

            <?php while ($s = mysqli_fetch_assoc($supplier)) { ?>
                <option value="<?= $s['id'] ?>"
                    <?= $b['supplier_id'] == $s['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($s['nama']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit" name="simpan">Simpan Perubahan</button>
        <a href="barang.php" class="btn">Kembali</a>

    </form>
</div>

</body>
</html>
