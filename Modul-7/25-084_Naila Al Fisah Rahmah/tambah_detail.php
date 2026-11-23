<?php
include 'koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($koneksi, "
    SELECT * FROM barang
    WHERE id NOT IN (
        SELECT barang_id
        FROM transaksi_detail
        WHERE transaksi_id = '$id'
    )
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Detail</title>

    <head>
        <title>Tambah Barang</title>

        <style>
            body {
                font-family: 'Segoe UI', Arial, sans-serif;
                background: #f5f4fa;
                padding: 30px;
                color: #252b40;
            }

            h2 {
                background: #172033;
                color: white;
                padding: 25px;
                border-radius: 12px;
                text-align: center;
            }

            form {
                background: white;
                max-width: 450px;
                margin: 40px auto;
                padding: 30px;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
            }

            label {
                font-weight: bold;
                color: #493b78;
            }

            select,
            input {
                width: 100%;
                padding: 12px;
                margin-top: 10px;
                margin-bottom: 20px;
                border: 1px solid #ddd;
                border-radius: 7px;
                box-sizing: border-box;
            }

            button {
                width: 100%;
                padding: 12px;
                background: #8064c8;
                color: white;
                border: none;
                border-radius: 7px;
                font-weight: bold;
                cursor: pointer;
            }

            button:hover {
                background: #6248a5;
            }

            a {
                color: #6248a5;
                text-decoration: none;
                font-weight: bold;
            }
        </style>
    </head>

</head>

<body>

    <h2>Tambah Barang ke Transaksi</h2>

    <form action="proses_detail.php" method="POST">

        <input type="hidden" name="transaksi_id" value="<?= $id; ?>">

        <label>Pilih Barang:</label>

        <select name="barang_id" required>
            <option value="">-- Pilih Barang --</option>

            <?php while ($barang = mysqli_fetch_assoc($query)) { ?>
                <option value="<?= $barang['id']; ?>">
                    <?= $barang['nama_barang']; ?>
                </option>
            <?php } ?>

        </select>

        <br><br>

        <label>Jumlah:</label>
        <input type="number" name="qty" min="1" required>

        <br><br>

        <button type="submit">Simpan</button>

    </form>

</body>

</html>