<?php
require 'koneksi.php';

if (isset($_POST['simpan'])) {
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $supplier_id = $_POST['supplier_id'];

    $query = "INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id)
              VALUES ('$kode_barang', '$nama_barang', '$harga', '$stok', '$supplier_id')";

    if (mysqli_query($conn, $query)) {
        header("Location: barang.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$query_supplier = "SELECT * FROM supplier";
$result_supplier = mysqli_query($conn, $query_supplier);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Barang</title>

    <style>
        body {
            font-family: Arial;
            margin: 30px;
        }

        h2 {
            color: #5b9aaa;
        }

        input, select {
            width: 300px;
            padding: 8px;
            margin: 8px 0;
        }

        button {
            background: #5cb85c;
            color: white;
            padding: 8px 15px;
            border: none;
            cursor: pointer;
        }

        .batal {
            background: #c9302c;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <h2>Tambah Data Barang</h2>

    <form method="POST">

        <label>Kode Barang</label><br>
        <input type="text" name="kode_barang" required><br>

        <label>Nama Barang</label><br>
        <input type="text" name="nama_barang" required><br>

        <label>Harga</label><br>
        <input type="number" name="harga" required><br>

        <label>Stok</label><br>
        <input type="number" name="stok" required><br>

        <label>Supplier</label><br>
        <select name="supplier_id" required>
            <option value="">-- Pilih Supplier --</option>

            <?php while ($supplier = mysqli_fetch_assoc($result_supplier)) { ?>
                <option value="<?php echo $supplier['id']; ?>">
                    <?php echo $supplier['nama']; ?>
                </option>
            <?php } ?>

        </select><br><br>

        <button type="submit" name="simpan">Simpan</button>
        <a href="barang.php" class="batal">Batal</a>

    </form>

</body>
</html>