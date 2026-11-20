<?php
include 'koneksi.php';
include 'auth.php';
cekOwner();

if (isset($_POST['simpan'])) {
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $supplier_id = $_POST['supplier_id'];

    mysqli_query($conn, "INSERT INTO barang
        (kode_barang, nama_barang, harga, stok, supplier_id)
        VALUES
        ('$kode_barang', '$nama_barang', '$harga', '$stok', '$supplier_id')");

    header("Location: barang.php");
    exit;
}

$supplier = mysqli_query($conn, "SELECT * FROM supplier");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>

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
    <h2>Tambah Barang</h2>

    <form method="POST">

        <label>Kode Barang</label>
        <input type="text" name="kode_barang" required>

        <label>Nama Barang</label>
        <input type="text" name="nama_barang" required>

        <label>Harga</label>
        <input type="number" name="harga" required>

        <label>Stok</label>
        <input type="number" name="stok" required>

        <label>Supplier</label>
        <select name="supplier_id" required>
            <option value="">Pilih Supplier</option>

            <?php while ($s = mysqli_fetch_assoc($supplier)) { ?>
                <option value="<?= $s['id'] ?>">
                    <?= htmlspecialchars($s['nama']) ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit" name="simpan">Simpan</button>
        <a href="barang.php" class="btn">Kembali</a>

    </form>
</div>

</body>
</html>
