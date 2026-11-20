<?php
require 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("ID transaksi tidak ditemukan!");
}

if (isset($_POST['simpan'])) {
    $barang_id = $_POST['barang_id'];
    $qty = $_POST['qty'];

    $query_barang = "SELECT harga FROM barang WHERE id='$barang_id'";
    $result_barang = mysqli_query($conn, $query_barang);
    $barang = mysqli_fetch_assoc($result_barang);

    if (!$barang || $qty <= 0) {
        echo "Barang atau jumlah tidak valid!";
    } else {
        $harga = $barang['harga'];

        $query_cek = "SELECT * FROM transaksi_detail
                      WHERE transaksi_id='$id'
                      AND barang_id='$barang_id'";

        $result_cek = mysqli_query($conn, $query_cek);

        if (mysqli_num_rows($result_cek) > 0) {
            echo "Barang sudah dimasukkan ke transaksi ini!";
        } else {

            $query = "INSERT INTO transaksi_detail
                      (transaksi_id, barang_id, harga, qty)
                      VALUES ('$id', '$barang_id', '$harga', '$qty')";

            if (mysqli_query($conn, $query)) {

                $query_total = "SELECT SUM(harga * qty) AS total
                                FROM transaksi_detail
                                WHERE transaksi_id='$id'";

                $result_total = mysqli_query($conn, $query_total);
                $data_total = mysqli_fetch_assoc($result_total);

                $total = $data_total['total'];

                $query_update = "UPDATE transaksi
                                 SET total='$total'
                                 WHERE id='$id'";

                if (mysqli_query($conn, $query_update)) {
                    header("Location: detail_transaksi.php?id=$id");
                    exit;
                } else {
                    echo "Error: " . mysqli_error($conn);
                }

            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }
}

$query_barang = "SELECT * FROM barang
                 WHERE id NOT IN (
                     SELECT barang_id
                     FROM transaksi_detail
                     WHERE transaksi_id='$id'
                 )";

$result_barang = mysqli_query($conn, $query_barang);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Detail Transaksi</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        h2 {
            color: #5b9aaa;
        }

        label {
            display: inline-block;
            width: 100px;
            margin-bottom: 15px;
        }

        select, input {
            padding: 8px;
            width: 220px;
        }

        button, a {
            padding: 8px 12px;
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .simpan {
            background-color: #5cb85c;
        }

        .batal {
            background-color: #c9302c;
        }
    </style>
</head>

<body>

    <h2>Tambah Detail Transaksi</h2>

    <form method="POST">

        <label>Barang</label>

        <select name="barang_id" required>
            <option value="">-- Pilih Barang --</option>

            <?php
            while ($row = mysqli_fetch_assoc($result_barang)) {
            ?>

            <option value="<?php echo $row['id']; ?>">
                <?php echo $row['kode_barang']; ?> -
                <?php echo $row['nama_barang']; ?>
            </option>

            <?php } ?>

        </select>

        <br><br>

        <label>Qty</label>
        <input type="number" name="qty" min="1" required>

        <br><br>

        <button type="submit" name="simpan" class="simpan">
            Simpan
        </button>

        <a href="detail_transaksi.php?id=<?php echo $id; ?>"
           class="batal">Batal</a>

    </form>

</body>
</html>