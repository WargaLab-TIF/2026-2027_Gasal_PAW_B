<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    die("ID transaksi tidak ditemukan. Silakan kembali ke halaman transaksi.");
}

$cek_transaksi = mysqli_query($conn, "
    SELECT * FROM transaksi WHERE id = $id
");

if (mysqli_num_rows($cek_transaksi) == 0) {
    die("Data transaksi tidak ditemukan.");
}

if (isset($_POST['simpan'])) {

    $barang_id = (int) $_POST['barang_id'];
    $qty = (int) $_POST['qty'];

    if ($barang_id <= 0 || $qty <= 0) {

        echo "<script>
            alert('Silakan pilih barang dan masukkan jumlah yang benar!');
        </script>";

    } else {

        $cek = mysqli_query($conn, "
            SELECT * FROM transaksi_detail
            WHERE transaksi_id = $id
            AND barang_id = $barang_id
        ");

        if (mysqli_num_rows($cek) > 0) {

            echo "<script>
                alert('Barang sudah dimasukkan!');
            </script>";

        } else {

            $data = mysqli_query($conn, "
                SELECT harga FROM barang
                WHERE id = $barang_id
            ");

            if (mysqli_num_rows($data) == 0) {

                echo "<script>
                    alert('Barang tidak ditemukan!');
                </script>";

            } else {

                $b = mysqli_fetch_assoc($data);
                $harga = $b['harga'];

                $simpan = mysqli_query($conn, "
                    INSERT INTO transaksi_detail
                    (transaksi_id, barang_id, harga, qty)
                    VALUES ($id, $barang_id, $harga, $qty)
                ");

                if ($simpan) {

                    mysqli_query($conn, "
                        UPDATE transaksi
                        SET total = (
                            SELECT COALESCE(SUM(harga * qty), 0)
                            FROM transaksi_detail
                            WHERE transaksi_id = $id
                        )
                        WHERE id = $id
                    ");

                    header("Location: transaksi.php?id=$id");
                    exit;

                } else {
                    echo "Gagal menyimpan detail: " . mysqli_error($conn);
                }
            }
        }
    }
}

$barang = mysqli_query($conn, "
    SELECT * FROM barang
    WHERE id NOT IN (
        SELECT barang_id
        FROM transaksi_detail
        WHERE transaksi_id = $id
    )
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Detail Transaksi</title>
</head>
<body>

<h2>Tambah Barang Transaksi</h2>

<form method="POST">

    <label>Barang</label><br>

    <select name="barang_id" required>
        <option value="">Pilih Barang</option>

        <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
            <option value="<?php echo $b['id']; ?>">
                <?php echo $b['nama_barang']; ?>
            </option>
        <?php } ?>

    </select>

    <br><br>

    <label>Jumlah</label><br>
    <input type="number" name="qty" min="1" required>

    <br><br>

    <button type="submit" name="simpan">Simpan</button>

</form>

<br>

<a href="transaksi.php?id=<?php echo $id; ?>">Kembali</a>

</body>
</html>
