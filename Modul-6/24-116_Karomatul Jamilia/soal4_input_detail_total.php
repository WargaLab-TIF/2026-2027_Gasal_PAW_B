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
    $sql = "SELECT id_transaksi, waktu_transaksi, keterangan FROM transaksi ORDER BY id_transaksi";
    return queryDatabase($koneksi, $sql);
}

function ambilSemuaBarang($koneksi)
{
    $sql = "SELECT id_barang, kode_barang, nama_barang, harga FROM barang ORDER BY nama_barang";
    return queryDatabase($koneksi, $sql);
}

function ambilHargaBarang($koneksi, $id_barang)
{
    $id_barang = (int)$id_barang;
    $sql = "SELECT harga FROM barang WHERE id_barang = $id_barang";
    $row = mysqli_fetch_assoc(queryDatabase($koneksi, $sql));
    return $row ? (int)$row["harga"] : null;
}

function transaksiAda($koneksi, $id)
{
    $id = (int)$id;
    $sql = "SELECT id_transaksi FROM transaksi WHERE id_transaksi = $id";
    return mysqli_fetch_assoc(queryDatabase($koneksi, $sql)) ? true : false;
}

function simpanDetail($koneksi, $id_transaksi, $id_barang, $harga, $qty)
{
    $sql = "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty)
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "iiii", $id_transaksi, $id_barang, $harga, $qty);

    return mysqli_stmt_execute($stmt);
}


function perbaruiTotal($koneksi, $id_transaksi)
{
    $sql = "UPDATE transaksi
            SET total = (SELECT COALESCE(SUM(harga * qty), 0)
                         FROM transaksi_detail
                         WHERE transaksi_id = ?)
            WHERE id_transaksi = ?";

    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id_transaksi, $id_transaksi);

    return mysqli_stmt_execute($stmt);
}

function ambilTransaksi($koneksi, $id)
{
    $id = (int)$id;
    $sql = "SELECT id_transaksi, waktu_transaksi, keterangan, total
            FROM transaksi WHERE id_transaksi = $id";
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

$koneksi = bukaKoneksi();
$pesan = "";
$id_pilih = (isset($_GET["id"]) && ctype_digit($_GET["id"])) ? (int)$_GET["id"] : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_transaksi = (int)($_POST["transaksi_id"] ?? 0);
    $id_barang    = (int)($_POST["barang_id"] ?? 0);
    $qty          = (int)($_POST["qty"] ?? 0);
    $id_pilih     = $id_transaksi;

    if ($id_transaksi <= 0 || $id_barang <= 0 || $qty <= 0) {
        $pesan = "Transaksi, barang, dan qty (minimal 1) harus diisi.";
    } elseif (!transaksiAda($koneksi, $id_transaksi)) {
        $pesan = "Transaksi tidak ditemukan.";
    } else {
        $harga = ambilHargaBarang($koneksi, $id_barang);
        if ($harga === null) {
            $pesan = "Barang tidak ditemukan.";
        } else {
            try {
                mysqli_begin_transaction($koneksi);

                if (!simpanDetail($koneksi, $id_transaksi, $id_barang, $harga, $qty)
                    || !perbaruiTotal($koneksi, $id_transaksi)) {
                    throw new Exception("Gagal menyimpan");
                }

                mysqli_commit($koneksi);

                header("Location: soal4_input_detail_total.php?id=" . $id_transaksi);
                exit;
            } catch (Throwable $e) {
                mysqli_rollback($koneksi);
                $pesan = "Detail gagal disimpan (barang mungkin sudah ada di transaksi ini).";
            }
        }
    }
}

$daftarTransaksi = ambilSemuaTransaksi($koneksi);
$daftarBarang    = ambilSemuaBarang($koneksi);
$transaksi       = $id_pilih > 0 ? ambilTransaksi($koneksi, $id_pilih) : null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Soal 4 - Input Detail & Update Total</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .judul { margin: 0; color: #4682B4; font-size: 24px; font-weight: 500; }
        .garis-bawah { border-bottom: 2px solid #f0f0f0; margin: 10px 0 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        tr.head { background-color: #D9EAF7; }
        .btn-hijau { background-color: #5cb85c; color: white; padding: 10px 20px;
                     border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .notif { padding: 12px 15px; border-radius: 4px; margin-bottom: 15px;
                 background: #f8d7da; color: #a94442; border: 1px solid #f1b0b7; }
        .master-box { background: #f7fafc; border: 1px solid #d9e6f2; border-radius: 4px;
                      padding: 15px; margin-bottom: 20px; }
        .form-detail { display: flex; gap: 12px; align-items: flex-end; margin-bottom: 25px; flex-wrap: wrap; }
        .form-detail label { display: block; font-weight: bold; margin-bottom: 5px; }
        .form-detail select, .form-detail input { padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .form-detail select { min-width: 220px; }
        .nav { display: flex; gap: 10px; margin-bottom: 20px; }
        .nav a { background-color: #4682B4; color: white; padding: 8px 15px;
                 text-decoration: none; border-radius: 4px; font-size: 14px; }
        .nav a.aktif { background-color: #E67E22; }
    </style>
</head>
<body>
    <div class="nav">
        <a href="soal2_master_detail.php">Data Transaksi</a>
        <a href="soal3_hapus_barang.php">Data Barang</a>
        <a href="soal4_input_detail_total.php" class="aktif">Input Detail & Total</a>
    </div>

    <p class="judul">Input Detail Transaksi</p>
    <div class="garis-bawah"></div>

    <?php if ($pesan != "") { ?>
        <div class="notif"><?= htmlspecialchars($pesan) ?></div>
    <?php } ?>

    <form method="post" class="form-detail">
        <div>
            <label>Transaksi</label>
            <select name="transaksi_id" required>
                <option value="">-- Pilih Transaksi --</option>
                <?php while ($t = mysqli_fetch_assoc($daftarTransaksi)) { ?>
                    <option value="<?= (int)$t["id_transaksi"] ?>"
                        <?= $t["id_transaksi"] == $id_pilih ? "selected" : "" ?>>
                        #<?= (int)$t["id_transaksi"] ?> - <?= htmlspecialchars($t["keterangan"]) ?>
                        (<?= htmlspecialchars($t["waktu_transaksi"]) ?>)
                    </option>
                <?php } ?>
            </select>
        </div>
        <div>
            <label>Barang</label>
            <select name="barang_id" required>
                <option value="">-- Pilih Barang --</option>
                <?php while ($b = mysqli_fetch_assoc($daftarBarang)) { ?>
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
        <button type="submit" class="btn-hijau">Simpan Detail</button>
    </form>

    <?php if ($transaksi) { $detail = ambilDetail($koneksi, $id_pilih); ?>
        <div class="master-box">
            <b>Transaksi #<?= (int)$transaksi["id_transaksi"] ?></b> |
            <?= htmlspecialchars($transaksi["waktu_transaksi"]) ?> |
            <?= htmlspecialchars($transaksi["keterangan"]) ?><br><br>
            <b>Total (kolom transaksi.total): Rp <?= number_format($transaksi["total"], 0, ',', '.') ?></b>
        </div>

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
    <?php } ?>
</body>
</html>
<?php mysqli_close($koneksi); ?>
