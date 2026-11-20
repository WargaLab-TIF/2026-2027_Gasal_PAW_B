<?php
require 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("ID barang tidak ditemukan!");
}

$query = "SELECT * FROM barang WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data barang tidak ditemukan!");
}

if (isset($_POST['simpan'])) {
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $supplier_id = $_POST['supplier_id'];

    $query = "UPDATE barang SET
              kode_barang = '$kode_barang',
              nama_barang = '$nama_barang',
              harga = '$harga',
              stok = '$stok',
              supplier_id = '$supplier_id'
              WHERE id = '$id'";

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
    <title>Edit Data Barang</title>

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

    <h2>Edit Data Barang</h2>

    <form method="POST">

        <label>Kode Barang</label><br>
        <input type="text" name="kode_barang"
               value="<?php echo $data['kode_barang']; ?>" required><br>

        <label>Nama Barang</label><br>
        <input type="text" name="nama_barang"
               value="<?php echo $data['nama_barang']; ?>" required><br>

        <label>Harga</label><br>
        <input type="number" name="harga"
               value="<?php echo $data['harga']; ?>" required><br>

        <label>Stok</label><br>
        <input type="number" name="stok"
               value="<?php echo $data['stok']; ?>" required><br>

        <label>Supplier</label><br>
        <select name="supplier_id" required>

            <?php while ($supplier = mysqli_fetch_assoc($result_supplier)) { ?>
                <option value="<?php echo $supplier['id']; ?>"
                    <?php if ($supplier['id'] == $data['supplier_id']) echo 'selected'; ?>>
                    <?php echo $supplier['nama']; ?>
                </option>
            <?php } ?>

        </select><br><br>

        <button type="submit" name="simpan">Simpan</button>
        <a href="barang.php" class="batal">Batal</a>

    </form>

</body>
</html>