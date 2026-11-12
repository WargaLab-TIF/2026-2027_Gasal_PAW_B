<?php
function bukaKoneksi()
{
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "db_penjualan";

    $koneksi = mysqli_connect($host, $user, $pass, $db);

    if (!$koneksi) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    return $koneksi;
}

function queryDatabase($koneksi, $sql)
{
    $hasil = mysqli_query($koneksi, $sql);

    if (!$hasil) {
        die("Query gagal: " . mysqli_error($koneksi));
    }

    return $hasil;
}

function ambilSemuaTransaksi($koneksi)
{
    $sql = "SELECT t.id_transaksi, t.waktu_transaksi, t.keterangan, p.nama AS nama_pelanggan
            FROM transaksi t
            LEFT JOIN pelanggan p ON t.pelanggan_id = p.id_pelanggan
            ORDER BY t.id_transaksi";
    return queryDatabase($koneksi, $sql);
}

function ambilMaster($koneksi, $id)
{
    $id = (int)$id;
    $sql = "SELECT t.id_transaksi, t.waktu_transaksi, t.keterangan, p.nama AS nama_pelanggan
            FROM transaksi t
            LEFT JOIN pelanggan p ON t.pelanggan_id = p.id_pelanggan
            WHERE t.id_transaksi = $id";
    return mysqli_fetch_assoc(queryDatabase($koneksi, $sql));
}

function ambilDetail($koneksi, $id)
{
    $id = (int)$id;
    $sql = "SELECT b.kode_barang, b.nama_barang, d.harga, d.qty
            FROM transaksi_detail d
            JOIN barang b ON d.barang_id = b.id_barang
            WHERE d.transaksi_id = $id";
    return queryDatabase($koneksi, $sql);
}

// hanya barang yang belum ada di detail transaksi ini
function ambilBarangTersedia($koneksi, $id)
{
    $id = (int)$id;
    $sql = "SELECT id_barang, kode_barang, nama_barang, harga
            FROM barang
            WHERE id_barang NOT IN (
                SELECT barang_id FROM transaksi_detail WHERE transaksi_id = $id
            )
            ORDER BY nama_barang";
    return queryDatabase($koneksi, $sql);
}

function barangSudahAda($koneksi, $id_transaksi, $id_barang)
{
    $id_transaksi = (int)$id_transaksi;
    $id_barang    = (int)$id_barang;
    $sql = "SELECT COUNT(*) AS jml FROM transaksi_detail
            WHERE transaksi_id = $id_transaksi AND barang_id = $id_barang";
    $row = mysqli_fetch_assoc(queryDatabase($koneksi, $sql));
    return $row["jml"] > 0;
}

function ambilHargaBarang($koneksi, $id_barang)
{
    $id_barang = (int)$id_barang;
    $sql = "SELECT harga FROM barang WHERE id_barang = $id_barang";
    $row = mysqli_fetch_assoc(queryDatabase($koneksi, $sql));
    return $row ? (int)$row["harga"] : null;
}

function simpanDetail($koneksi, $id_transaksi, $id_barang, $harga, $qty)
{
    $sql = "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty)
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "iiii", $id_transaksi, $id_barang, $harga, $qty);

    return mysqli_stmt_execute($stmt);
}

$koneksi = bukaKoneksi();
$pesan = "";
$id_transaksi = (isset($_GET["id"]) && ctype_digit($_GET["id"])) ? (int)$_GET["id"] : 0;

// proses simpan detail
if ($_SERVER["REQUEST_METHOD"] == "POST" && $id_transaksi > 0) {
    $id_barang = (int)($_POST["barang_id"] ?? 0);
    $qty       = (int)($_POST["qty"] ?? 0);

    if ($id_barang <= 0 || $qty <= 0) {
        $pesan = "Barang harus dipilih dan qty minimal 1.";
    } elseif (barangSudahAda($koneksi, $id_transaksi, $id_barang)) {
        $pesan = "Barang tersebut sudah ada di transaksi ini.";
    } else {
        $harga = ambilHargaBarang($koneksi, $id_barang);
        if ($harga === null) {
            $pesan = "Barang tidak ditemukan.";
        } else {
            simpanDetail($koneksi, $id_transaksi, $id_barang, $harga, $qty);
            header("Location: soal2_master_detail.php?id=" . $id_transaksi);
            exit;
        }
    }
}

$daftarTransaksi = ambilSemuaTransaksi($koneksi);
$master = $id_transaksi > 0 ? ambilMaster($koneksi, $id_transaksi) : null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Soal 2 - Master Detail Transaksi</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .judul { margin: 0; color: #4682B4; font-size: 24px; font-weight: 500; }
        .garis-bawah { border-bottom: 2px solid #f0f0f0; margin: 10px 0 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        tr.head { background-color: #D9EAF7; }
        tr.aktif { background-color: #fff6e0; }
        .btn { color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px;
               display: inline-block; border: none; cursor: pointer; font-size: 14px; }
        .btn-oranye { background-color: #E67E22; }
        .btn-hijau { background-color: #5cb85c; }
        .notif { padding: 12px 15px; border-radius: 4px; margin-bottom: 15px;
                 background: #f8d7da; color: #a94442; border: 1px solid #f1b0b7; }
        .info { background: #dff0d8; color: #3c763d; border: 1px solid #c3e0b5;
                padding: 12px 15px; border-radius: 4px; margin-bottom: 15px; }
        .master-box { background: #f7fafc; border: 1px solid #d9e6f2; border-radius: 4px;
                      padding: 15px; margin-bottom: 20px; }
        .form-detail { display: flex; gap: 12px; align-items: flex-end; margin-bottom: 20px; }
        .form-detail label { display: block; font-weight: bold; margin-bottom: 5px; }
        .form-detail select, .form-detail input { padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .form-detail select { min-width: 280px; }
        .nav { display: flex; gap: 10px; margin-bottom: 20px; }
        .nav a { background-color: #4682B4; color: white; padding: 8px 15px;
                 text-decoration: none; border-radius: 4px; font-size: 14px; }
        .nav a.aktif { background-color: #E67E22; }
    </style>
</head>
<body>
    <div class="nav">
        <a href="soal2_master_detail.php" class="aktif">Data Transaksi</a>
        <a href="soal3_hapus_barang.php">Data Barang</a>
        <a href="soal4_input_detail_total.php">Input Detail & Total</a>
    </div>

    <p class="judul">Master Detail Transaksi</p>
    <div class="garis-bawah"></div>

    
    <b>Master Transaksi</b>
    <table>
        <tr class="head">
            <th>No</th><th>Tanggal</th><th>Pelanggan</th><th>Keterangan</th><th>Tindakan</th>
        </tr>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($daftarTransaksi)) { ?>
        <tr <?= $row["id_transaksi"] == $id_transaksi ? 'class="aktif"' : '' ?>>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row["waktu_transaksi"]) ?></td>
            <td><?= htmlspecialchars($row["nama_pelanggan"] ?? "-") ?></td>
            <td><?= htmlspecialchars($row["keterangan"]) ?></td>
            <td><a href="?id=<?= (int)$row["id_transaksi"] ?>" class="btn btn-oranye">Lihat Detail</a></td>
        </tr>
        <?php } ?>
    </table>

    
    <?php if ($master) {
        $detail = ambilDetail($koneksi, $id_transaksi);
        $barang = ambilBarangTersedia($koneksi, $id_transaksi);
    ?>
        <div class="master-box">
            <b>Transaksi #<?= (int)$master["id_transaksi"] ?></b> |
            <?= htmlspecialchars($master["waktu_transaksi"]) ?> |
            <?= htmlspecialchars($master["nama_pelanggan"] ?? "-") ?> |
            <?= htmlspecialchars($master["keterangan"]) ?>
        </div>

        <?php if ($pesan != "") { ?>
            <div class="notif"><?= htmlspecialchars($pesan) ?></div>
        <?php } ?>

        <?php if (mysqli_num_rows($barang) > 0) { ?>
        <form method="post" class="form-detail">
            <div>
                <label>Barang</label>
                <select name="barang_id" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
                        <option value="<?= (int)$b["id_barang"] ?>">
                            <?= htmlspecialchars($b["kode_barang"] . " - " . $b["nama_barang"]) ?>
                            (Rp <?= number_format($b["harga"], 0, ',', '.') ?>)
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <label>Qty</label>
                <input type="number" name="qty" min="1" value="1" required>
            </div>
            <button type="submit" class="btn btn-hijau">Tambah Detail</button>
        </form>
        <?php } else { ?>
            <div class="info">Semua barang sudah dimasukkan ke transaksi ini.</div>
        <?php } ?>

        <b>Detail Transaksi</b>
        <table>
            <tr class="head">
                <th>No</th><th>Kode</th><th>Nama Barang</th><th>Harga</th><th>Qty</th><th>Subtotal</th>
            </tr>
            <?php $no = 1; $ada = false; while ($d = mysqli_fetch_assoc($detail)) { $ada = true; ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($d["kode_barang"]) ?></td>
                <td><?= htmlspecialchars($d["nama_barang"]) ?></td>
                <td>Rp <?= number_format($d["harga"], 0, ',', '.') ?></td>
                <td><?= (int)$d["qty"] ?></td>
                <td>Rp <?= number_format($d["harga"] * $d["qty"], 0, ',', '.') ?></td>
            </tr>
            <?php } ?>
            <?php if (!$ada) { ?>
            <tr><td colspan="6" style="text-align:center;">Belum ada detail transaksi.</td></tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <div class="info">Klik "Lihat Detail" pada salah satu transaksi untuk menampilkan detailnya.</div>
    <?php } ?>
</body>
</html>
<?php mysqli_close($koneksi); ?>
