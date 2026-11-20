<?php
include 'auth.php';
wajibLogin();
include 'koneksi.php';

$pesan = "";

if (isset($_POST['buat_transaksi'])) {
    $pelanggan_id = (int) $_POST['pelanggan_id'];
    $keterangan = $_POST['keterangan'];

    $stmt = mysqli_prepare($conn,
        "INSERT INTO transaksi
        (waktu_transaksi, pelanggan_id, total, keterangan)
        VALUES (NOW(), ?, 0, ?)"
    );

    mysqli_stmt_bind_param($stmt, "is", $pelanggan_id, $keterangan);

    if (mysqli_stmt_execute($stmt)) {
        $id_baru = mysqli_insert_id($conn);

        header("Location: transaksi.php?id=" . $id_baru);
        exit;
    } else {
        $pesan = "Gagal membuat transaksi!";
    }
}

$transaksi_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$transaksiDipilih = null;

if ($transaksi_id > 0) {
    $stmt = mysqli_prepare($conn,
        "SELECT transaksi.*, pelanggan.nama AS nama_pelanggan
        FROM transaksi
        LEFT JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
        WHERE transaksi.id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $transaksi_id);
    mysqli_stmt_execute($stmt);

    $transaksiDipilih = mysqli_fetch_assoc(
        mysqli_stmt_get_result($stmt)
    );

    if (!$transaksiDipilih) {
        $transaksi_id = 0;
        $pesan = "Transaksi tidak ditemukan!";
    }
}

if (isset($_POST['simpan_detail'])) {
    $transaksi_id = (int) $_POST['transaksi_id'];
    $barang_id = (int) $_POST['barang_id'];
    $qty = (int) $_POST['qty'];

    if ($qty <= 0) {
        $pesan = "Jumlah barang harus lebih dari 0!";
    } else {

        $cek = mysqli_prepare($conn,
            "SELECT id FROM transaksi_detail
            WHERE transaksi_id = ? AND barang_id = ?"
        );

        mysqli_stmt_bind_param($cek, "ii", $transaksi_id, $barang_id);
        mysqli_stmt_execute($cek);

        $hasilCek = mysqli_stmt_get_result($cek);

        if (mysqli_num_rows($hasilCek) > 0) {
            $pesan = "Barang sudah ada dalam transaksi!";
        } else {

            $stmt = mysqli_prepare($conn,
                "SELECT harga FROM barang WHERE id = ?"
            );

            mysqli_stmt_bind_param($stmt, "i", $barang_id);
            mysqli_stmt_execute($stmt);

            $dataBarang = mysqli_fetch_assoc(
                mysqli_stmt_get_result($stmt)
            );

            if ($dataBarang) {
                $harga = $dataBarang['harga'];

                $stmt = mysqli_prepare($conn,
                    "INSERT INTO transaksi_detail
                    (transaksi_id, barang_id, harga, qty)
                    VALUES (?, ?, ?, ?)"
                );

                mysqli_stmt_bind_param(
                    $stmt, "iiii",
                    $transaksi_id, $barang_id, $harga, $qty
                );

                if (mysqli_stmt_execute($stmt)) {

                    $stmt = mysqli_prepare($conn,
                        "UPDATE transaksi
                        SET total = (
                            SELECT SUM(harga * qty)
                            FROM transaksi_detail
                            WHERE transaksi_id = ?
                        )
                        WHERE id = ?"
                    );

                    mysqli_stmt_bind_param(
                        $stmt, "ii",
                        $transaksi_id, $transaksi_id
                    );

                    mysqli_stmt_execute($stmt);

                    header("Location: transaksi.php?id=" . $transaksi_id);
                    exit;

                } else {
                    $pesan = "Gagal menyimpan detail transaksi!";
                }

            } else {
                $pesan = "Barang tidak ditemukan!";
            }
        }
    }
}

$dataTransaksi = mysqli_query($conn,
    "SELECT transaksi.*, pelanggan.nama AS nama_pelanggan
    FROM transaksi
    LEFT JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
    ORDER BY transaksi.id DESC"
);

$dataPelanggan = mysqli_query($conn,
    "SELECT * FROM pelanggan ORDER BY nama ASC"
);

$dataBarang = false;

if ($transaksi_id > 0) {
    $stmt = mysqli_prepare($conn,
        "SELECT * FROM barang
        WHERE id NOT IN (
            SELECT barang_id
            FROM transaksi_detail
            WHERE transaksi_id = ?
        )
        ORDER BY nama_barang ASC"
    );

    mysqli_stmt_bind_param($stmt, "i", $transaksi_id);
    mysqli_stmt_execute($stmt);

    $dataBarang = mysqli_stmt_get_result($stmt);
}

$dataDetail = false;

if ($transaksi_id > 0) {
    $stmt = mysqli_prepare($conn,
        "SELECT transaksi_detail.*, barang.kode_barang,
        barang.nama_barang
        FROM transaksi_detail
        JOIN barang ON transaksi_detail.barang_id = barang.id
        WHERE transaksi_detail.transaksi_id = ?
    ");

    mysqli_stmt_bind_param($stmt, "i", $transaksi_id);
    mysqli_stmt_execute($stmt);

    $dataDetail = mysqli_stmt_get_result($stmt);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Penjualan</title>
</head>
<body>

<?php include 'navbar.php'; ?>

<h2>Transaksi Penjualan</h2>

<p style="color:red;">
    <?= htmlspecialchars($pesan) ?>
</p>

<hr>

<h3>Buat Transaksi Baru</h3>

<form method="POST">

    <label>Pilih Pelanggan</label><br>

    <select name="pelanggan_id" required>
        <option value="">-- Pilih Pelanggan --</option>

        <?php while ($p = mysqli_fetch_assoc($dataPelanggan)) { ?>
            <option value="<?= $p['id'] ?>">
                <?= htmlspecialchars($p['nama']) ?>
            </option>
        <?php } ?>

    </select>

    <br><br>

    <label>Keterangan</label><br>

    <textarea name="keterangan"></textarea>

    <br><br>

    <button type="submit" name="buat_transaksi">
        Buat Transaksi
    </button>

</form>

<hr>

<h3>Daftar Transaksi</h3>

<table border="1" cellpadding="8" cellspacing="0">

    <tr>
        <th>No</th>
        <th>ID Transaksi</th>
        <th>Waktu Transaksi</th>
        <th>Pelanggan</th>
        <th>Total</th>
        <th>Keterangan</th>
        <th>Aksi</th>
    </tr>

    <?php $no = 1; ?>

    <?php while ($row = mysqli_fetch_assoc($dataTransaksi)) { ?>

    <tr>
        <td><?= $no++ ?></td>

        <td><?= $row['id'] ?></td>

        <td><?= htmlspecialchars($row['waktu_transaksi']) ?></td>

        <td><?= htmlspecialchars($row['nama_pelanggan'] ?? '-') ?></td>

        <td>
            Rp <?= number_format($row['total'], 0, ',', '.') ?>
        </td>

        <td><?= htmlspecialchars($row['keterangan'] ?? '') ?></td>

        <td>
            <a href="transaksi.php?id=<?= $row['id'] ?>">
                Lihat Detail
            </a>
        </td>
    </tr>

    <?php } ?>

</table>

<?php if ($transaksi_id > 0 && $transaksiDipilih) { ?>

<hr>

<h3>Detail Transaksi</h3>

<p>
    ID Transaksi:
    <?= $transaksiDipilih['id'] ?>
</p>

<p>
    Nama Pelanggan:
    <?= htmlspecialchars($transaksiDipilih['nama_pelanggan'] ?? '-') ?>
</p>

<p>
    Waktu Transaksi:
    <?= htmlspecialchars($transaksiDipilih['waktu_transaksi']) ?>
</p>

<h3>Tambah Barang</h3>

<form method="POST">

    <input type="hidden" name="transaksi_id"
        value="<?= $transaksi_id ?>">

    <label>Pilih Barang</label><br>

    <select name="barang_id" required>

        <option value="">-- Pilih Barang --</option>

        <?php while ($b = mysqli_fetch_assoc($dataBarang)) { ?>

            <option value="<?= $b['id'] ?>">
                <?= htmlspecialchars($b['kode_barang']) ?>
                -
                <?= htmlspecialchars($b['nama_barang']) ?>
                (Rp <?= number_format($b['harga'], 0, ',', '.') ?>)
            </option>

        <?php } ?>

    </select>

    <br><br>

    <label>Jumlah Barang</label><br>

    <input type="number" name="qty" min="1" required>

    <br><br>

    <button type="submit" name="simpan_detail">
        Tambahkan Barang
    </button>

</form>

<hr>

<h3>Daftar Detail Barang</h3>

<table border="1" cellpadding="8" cellspacing="0">

    <tr>
        <th>No</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Qty</th>
        <th>Subtotal</th>
    </tr>

    <?php
    $no = 1;
    $total = 0;
    ?>

    <?php while ($d = mysqli_fetch_assoc($dataDetail)) { ?>

        <?php
        $subtotal = $d['harga'] * $d['qty'];
        $total += $subtotal;
        ?>

        <tr>
            <td><?= $no++ ?></td>

            <td><?= htmlspecialchars($d['kode_barang']) ?></td>

            <td><?= htmlspecialchars($d['nama_barang']) ?></td>

            <td>
                Rp <?= number_format($d['harga'], 0, ',', '.') ?>
            </td>

            <td><?= $d['qty'] ?></td>

            <td>
                Rp <?= number_format($subtotal, 0, ',', '.') ?>
            </td>
        </tr>

    <?php } ?>

    <tr>
        <th colspan="5">Total Transaksi</th>

        <th>
            Rp <?= number_format($total, 0, ',', '.') ?>
        </th>
    </tr>

</table>

<?php } ?>

</body>
</html>