<?php
include 'koneksi.php';

$pesan = "";

$transaksi_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if (isset($_POST['simpan_detail'])) {

    $transaksi_id = (int) $_POST['transaksi_id'];
    $barang_id = (int) $_POST['barang_id'];
    $qty = (int) $_POST['qty'];

    if ($qty <= 0) {

        $pesan = "Qty harus lebih dari 0!";

    } else {

        $cek_transaksi = mysqli_prepare($conn, "
            SELECT id FROM transaksi WHERE id = ?
        ");

        mysqli_stmt_bind_param(
            $cek_transaksi,
            "i",
            $transaksi_id
        );

        mysqli_stmt_execute($cek_transaksi);

        $hasil_transaksi = mysqli_stmt_get_result($cek_transaksi);

        if (!mysqli_fetch_assoc($hasil_transaksi)) {

            $pesan = "Transaksi tidak ditemukan!";

        } else {

            $cek_barang = mysqli_prepare($conn, "
                SELECT harga FROM barang WHERE id = ?
            ");

            mysqli_stmt_bind_param(
                $cek_barang,
                "i",
                $barang_id
            );

            mysqli_stmt_execute($cek_barang);

            $hasil_barang = mysqli_stmt_get_result($cek_barang);

            $barang = mysqli_fetch_assoc($hasil_barang);

            if (!$barang) {

                $pesan = "Barang tidak ditemukan!";

            } else {

                $harga = $barang['harga'];

                $cek_detail = mysqli_prepare($conn, "
                    SELECT id
                    FROM transaksi_detail
                    WHERE transaksi_id = ?
                    AND barang_id = ?
                ");

                mysqli_stmt_bind_param(
                    $cek_detail,
                    "ii",
                    $transaksi_id,
                    $barang_id
                );

                mysqli_stmt_execute($cek_detail);

                $hasil_detail = mysqli_stmt_get_result($cek_detail);

                if (mysqli_num_rows($hasil_detail) > 0) {

                    $pesan = "Barang sudah dimasukkan dalam transaksi ini!";

                } else {

                    mysqli_begin_transaction($conn);

                    try {

                        $insert = mysqli_prepare($conn, "
                            INSERT INTO transaksi_detail
                            (transaksi_id, barang_id, harga, qty)
                            VALUES (?, ?, ?, ?)
                        ");

                        mysqli_stmt_bind_param(
                            $insert,
                            "iiii",
                            $transaksi_id,
                            $barang_id,
                            $harga,
                            $qty
                        );

                        if (!mysqli_stmt_execute($insert)) {
                            throw new Exception(
                                mysqli_stmt_error($insert)
                            );
                        }

                        $update = mysqli_prepare($conn, "
                            UPDATE transaksi
                            SET total = (
                                SELECT COALESCE(SUM(harga * qty), 0)
                                FROM transaksi_detail
                                WHERE transaksi_id = ?
                            )
                            WHERE id = ?
                        ");

                        mysqli_stmt_bind_param(
                            $update,
                            "ii",
                            $transaksi_id,
                            $transaksi_id
                        );

                        if (!mysqli_stmt_execute($update)) {
                            throw new Exception(
                                mysqli_stmt_error($update)
                            );
                        }

                        mysqli_commit($conn);

                        header(
                            "Location: transaksi.php?id=" . $transaksi_id
                        );

                        exit;

                    } catch (Exception $e) {

                        mysqli_rollback($conn);

                        $pesan = "Gagal menyimpan detail transaksi!";

                    }
                }
            }
        }
    }
}

$query_transaksi = mysqli_query($conn, "
    SELECT
        transaksi.*,
        pelanggan.nama AS nama_pelanggan
    FROM transaksi
    LEFT JOIN pelanggan
        ON transaksi.pelanggan_id = pelanggan.id
    ORDER BY transaksi.id ASC
");

$transaksi = null;

if ($transaksi_id > 0) {

    $cek_transaksi = mysqli_prepare($conn, "
        SELECT * FROM transaksi WHERE id = ?
    ");

    mysqli_stmt_bind_param(
        $cek_transaksi,
        "i",
        $transaksi_id
    );

    mysqli_stmt_execute($cek_transaksi);

    $hasil_transaksi = mysqli_stmt_get_result($cek_transaksi);

    $transaksi = mysqli_fetch_assoc($hasil_transaksi);

}

$detail = null;
$barang_tersedia = null;

if ($transaksi) {

    $query_detail = mysqli_prepare($conn, "
        SELECT
            transaksi_detail.*,
            barang.kode_barang,
            barang.nama_barang
        FROM transaksi_detail
        JOIN barang
            ON transaksi_detail.barang_id = barang.id
        WHERE transaksi_detail.transaksi_id = ?
        ORDER BY transaksi_detail.id ASC
    ");

    mysqli_stmt_bind_param(
        $query_detail,
        "i",
        $transaksi_id
    );

    mysqli_stmt_execute($query_detail);

    $detail = mysqli_stmt_get_result($query_detail);

    $query_barang = mysqli_prepare($conn, "
        SELECT *
        FROM barang
        WHERE NOT EXISTS (
            SELECT 1
            FROM transaksi_detail
            WHERE transaksi_detail.barang_id = barang.id
            AND transaksi_detail.transaksi_id = ?
        )
        ORDER BY nama_barang ASC
    ");

    mysqli_stmt_bind_param(
        $query_barang,
        "i",
        $transaksi_id
    );

    mysqli_stmt_execute($query_barang);

    $barang_tersedia = mysqli_stmt_get_result($query_barang);

}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Master Detail Penjualan</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 30px;
            color: #333;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        h2 {
            color: #333;
        }

        h3 {
            margin-top: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #2878c8;
            color: white;
        }

        tr:nth-child(even) {
            background: #f4f6f9;
        }

        a, button {
            background: #2878c8;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: inline-block;
        }

        input, select {
            padding: 8px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .pesan {
            color: red;
            margin: 10px 0;
        }

        .total {
            font-weight: bold;
            font-size: 18px;
            margin-top: 20px;
        }

        .laporan {
            background: #198754;
            margin-bottom: 15px;
        }

        .barang {
            background: #555;
        }

        .kosong {
            text-align: center;
            color: #777;
        }

        @media (max-width: 600px) {

            body {
                margin: 15px;
            }

            .container {
                overflow-x: auto;
            }

            table {
                min-width: 600px;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <h2>Data Master Transaksi</h2>

    <a href="laporan.php" class="laporan">
        Laporan Penjualan
    </a>

    <a href="barang.php" class="barang">
        Data Barang
    </a>

    <table>

        <thead>

            <tr>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>

        </thead>

        <tbody>

            <?php while ($row = mysqli_fetch_assoc($query_transaksi)) { ?>

                <tr>

                    <td>
                        <?= $row['id']; ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['waktu_transaksi']); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($row['nama_pelanggan'] ?? '-'); ?>
                    </td>

                    <td>
                        Rp <?= number_format(
                            $row['total'],
                            0,
                            ',',
                            '.'
                        ); ?>
                    </td>

                    <td>

                        <a href="transaksi.php?id=<?= $row['id']; ?>">
                            Lihat Detail
                        </a>

                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>

</div>


<?php if ($transaksi) { ?>

<div class="container">

    <h2>Detail Transaksi #<?= $transaksi['id']; ?></h2>

    <p>
        Tanggal:
        <?= htmlspecialchars($transaksi['waktu_transaksi']); ?>
    </p>

    <p>
        Keterangan:
        <?= htmlspecialchars($transaksi['keterangan'] ?? '-'); ?>
    </p>

    <?php if ($pesan != "") { ?>

        <p class="pesan">
            <?= htmlspecialchars($pesan); ?>
        </p>

    <?php } ?>


    <h3>Tambah Detail Barang</h3>

    <form method="POST">

        <input
            type="hidden"
            name="transaksi_id"
            value="<?= $transaksi_id; ?>"
        >

        <label>Barang:</label>

        <select name="barang_id" required>

            <option value="">
                -- Pilih Barang --
            </option>

            <?php while ($b = mysqli_fetch_assoc($barang_tersedia)) { ?>

                <option value="<?= $b['id']; ?>">

                    <?= htmlspecialchars($b['nama_barang']); ?>

                    - Rp <?= number_format(
                        $b['harga'],
                        0,
                        ',',
                        '.'
                    ); ?>

                </option>

            <?php } ?>

        </select>

        <label>Qty:</label>

        <input
            type="number"
            name="qty"
            min="1"
            required
        >

        <button
            type="submit"
            name="simpan_detail"
        >
            Simpan Detail
        </button>

    </form>


    <h3>Daftar Detail Barang</h3>

    <table>

        <thead>

            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>

        </thead>

        <tbody>

            <?php

            $total = 0;

            if (mysqli_num_rows($detail) > 0) {

                while ($d = mysqli_fetch_assoc($detail)) {

                    $subtotal = $d['harga'] * $d['qty'];

                    $total += $subtotal;

            ?>

                <tr>

                    <td>
                        <?= htmlspecialchars($d['kode_barang']); ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($d['nama_barang']); ?>
                    </td>

                    <td>
                        Rp <?= number_format(
                            $d['harga'],
                            0,
                            ',',
                            '.'
                        ); ?>
                    </td>

                    <td>
                        <?= $d['qty']; ?>
                    </td>

                    <td>
                        Rp <?= number_format(
                            $subtotal,
                            0,
                            ',',
                            '.'
                        ); ?>
                    </td>

                </tr>

            <?php

                }

            } else {

            ?>

                <tr>
                    <td colspan="5" class="kosong">Belum ada detail barang dalam transaksi ini.</td>
                </tr>

            <?php } ?>

        </tbody>

    </table>


    <p class="total">

        Total Transaksi:

        Rp <?= number_format(
            $total,
            0,
            ',',
            '.'
        ); ?>

    </p>

</div>

<?php } elseif ($transaksi_id > 0) { ?>

<div class="container">

    <p class="pesan">Data transaksi tidak ditemukan!</p>

</div>

<?php } ?>

</body>
</html>