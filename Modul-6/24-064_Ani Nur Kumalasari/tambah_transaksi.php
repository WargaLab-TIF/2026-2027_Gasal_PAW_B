<?php
include "koneksi.php";

// Mengambil daftar pelanggan
$pelanggan = mysqli_query($koneksi, "
    SELECT * FROM pelanggan ORDER BY nama ASC
");

// Mengambil daftar barang
$barang = mysqli_query($koneksi, "
    SELECT * FROM barang ORDER BY nama_barang ASC
");

if (isset($_POST['simpan'])) {

    $pelanggan_id = $_POST['pelanggan_id'];
    $waktu = str_replace('T', ' ', $_POST['waktu_transaksi']);
    $keterangan = $_POST['keterangan'];

    $barang_id = (int) $_POST['barang_id'];
    $qty = (int) $_POST['qty'];

    if (empty($pelanggan_id) || $barang_id <= 0 || $qty <= 0) {
        die("Pelanggan, barang, dan jumlah harus diisi dengan benar.");
    }

    // Mengambil harga barang
    $stmt = mysqli_prepare($koneksi, "
        SELECT harga FROM barang WHERE id = ?
    ");
    mysqli_stmt_bind_param($stmt, "i", $barang_id);
    mysqli_stmt_execute($stmt);

    $data_barang = mysqli_fetch_assoc(
        mysqli_stmt_get_result($stmt)
    );

    if (!$data_barang) {
        die("Barang tidak ditemukan.");
    }

    $harga = (int) $data_barang['harga'];
    $total = $harga * $qty;

    // Menyimpan transaksi dan detailnya
    mysqli_begin_transaction($koneksi);

    try {

        // Simpan transaksi utama beserta pelanggan
        $stmt = mysqli_prepare($koneksi, "
            INSERT INTO transaksi
            (pelanggang_id, waktu_transaksi, keterangan, total)
            VALUES (?, ?, ?, ?)
        ");

        mysqli_stmt_bind_param(
            $stmt,
            "sssi",
            $pelanggan_id,
            $waktu,
            $keterangan,
            $total
        );

        mysqli_stmt_execute($stmt);

        // Mengambil ID transaksi yang baru dibuat
        $transaksi_id = mysqli_insert_id($koneksi);

        // Simpan detail barang
        $stmt = mysqli_prepare($koneksi, "
            INSERT INTO transaksi_detail
            (transaksi_id, barang_id, harga, qty)
            VALUES (?, ?, ?, ?)
        ");

        mysqli_stmt_bind_param(
            $stmt,
            "iiii",
            $transaksi_id,
            $barang_id,
            $harga,
            $qty
        );

        mysqli_stmt_execute($stmt);

        mysqli_commit($koneksi);

        header("Location: master-detail.php");
        exit;

    } catch (Exception $e) {

        mysqli_rollback($koneksi);
        die("Gagal menyimpan transaksi: " .
            htmlspecialchars($e->getMessage()));
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Transaksi</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 25px;
            color: #555;
        }

        h2 {
            color: #39758d;
            font-size: 24px;
            font-weight: normal;
            border-bottom: 1px solid #ddd;
            padding-bottom: 12px;
        }

        .form {
            width: 500px;
            margin: 30px auto;
        }

        .baris {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        label {
            width: 130px;
            text-align: right;
            margin-right: 20px;
            font-weight: bold;
        }

        input, select {
            width: 270px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: Arial;
        }

        .simpan {
            margin-left: 150px;
            background: #75ad43;
            color: white;
            border: none;
            padding: 9px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        .batal {
            background: #c82333;
            color: white;
            padding: 9px 15px;
            text-decoration: none;
            border-radius: 4px;
        }

        .total {
            font-weight: bold;
            color: #39758d;
        }
    </style>
</head>

<body>

<h2>Tambah Data Transaksi</h2>

<form method="POST" class="form">

    <div class="baris">
        <label>Nama Pelanggan</label>
        <select name="pelanggan_id" required>
            <option value="">-- Pilih Pelanggan --</option>

            <?php while ($p = mysqli_fetch_assoc($pelanggan)) { ?>
                <option value="<?= htmlspecialchars($p['id']); ?>">
                    <?= htmlspecialchars($p['nama']); ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="baris">
        <label>Waktu Transaksi</label>
        <input type="datetime-local"
               name="waktu_transaksi" required>
    </div>

    <div class="baris">
        <label>Keterangan</label>
        <input type="text" name="keterangan"
               placeholder="Keterangan transaksi" required>
    </div>

    <div class="baris">
        <label>Pilih Barang</label>
        <select name="barang_id" id="barang" required
                onchange="hitungTotal()">

            <option value="" data-harga="0">
                -- Pilih Barang --
            </option>

            <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
                <option value="<?= $b['id']; ?>"
                        data-harga="<?= $b['harga']; ?>">
                    <?= htmlspecialchars($b['nama_barang']); ?>
                </option>
            <?php } ?>

        </select>
    </div>

    <div class="baris">
        <label>Harga</label>
        <input type="text" id="harga" value="Rp 0" readonly>
    </div>

    <div class="baris">
        <label>Jumlah Barang</label>
        <input type="number" name="qty" id="qty"
               min="1" value="1" required
               oninput="hitungTotal()">
    </div>

    <div class="baris">
        <label>Total Harga</label>
        <input type="text" id="total" value="Rp 0"
               class="total" readonly>
    </div>

    <button type="submit" name="simpan" class="simpan">
        Simpan
    </button>

    <a href="master-detail.php" class="batal">Batal</a>

</form>

<script>
function hitungTotal() {

    let barang = document.getElementById("barang");
    let harga = parseInt(
        barang.options[barang.selectedIndex].dataset.harga
    ) || 0;

    let qty = parseInt(document.getElementById("qty").value) || 0;

    let total = harga * qty;

    document.getElementById("harga").value =
        "Rp " + harga.toLocaleString("id-ID");

    document.getElementById("total").value =
        "Rp " + total.toLocaleString("id-ID");
}
</script>

</body>
</html>
