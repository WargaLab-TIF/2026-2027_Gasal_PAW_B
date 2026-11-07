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

function ambilBarang($koneksi, $id)
{
    $id = (int)$id;
    $sql = "SELECT nama_barang FROM barang WHERE id_barang = $id";
    return mysqli_fetch_assoc(queryDatabase($koneksi, $sql));
}

// cek apakah barang sudah dipakai di transaksi_detail
function jumlahPemakaian($koneksi, $id)
{
    $id = (int)$id;
    $sql = "SELECT COUNT(*) AS jml FROM transaksi_detail WHERE barang_id = $id";
    $row = mysqli_fetch_assoc(queryDatabase($koneksi, $sql));
    return (int)$row["jml"];
}

function hapusBarang($koneksi, $id)
{
    $sql = "DELETE FROM barang
            WHERE id_barang = ?";

    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    return mysqli_stmt_execute($stmt);
}

$koneksi = bukaKoneksi();
$pesan = "";
$tipe  = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int)($_POST["id_barang"] ?? 0);
    $barang = ambilBarang($koneksi, $id);

    if (!$barang) {
        $pesan = "Data barang tidak ditemukan.";
        $tipe  = "gagal";
    } elseif (jumlahPemakaian($koneksi, $id) > 0) {
        $pesan = "Barang \"" . $barang["nama_barang"] . "\" tidak dapat dihapus karena masih digunakan pada transaksi.";
        $tipe  = "gagal";
    } else {
        hapusBarang($koneksi, $id);
        $pesan = "Barang \"" . $barang["nama_barang"] . "\" berhasil dihapus.";
        $tipe  = "sukses";
    }
}

$sql = "SELECT b.id_barang, b.kode_barang, b.nama_barang, b.harga, b.stok, s.nama AS nama_supplier
        FROM barang b
        LEFT JOIN supplier s ON b.supplier_id = s.id_supplier
        ORDER BY b.id_barang";
$hasil = queryDatabase($koneksi, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Soal 3 - Hapus Data Barang</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .judul { margin: 0; color: #4682B4; font-size: 24px; font-weight: 500; }
        .garis-bawah { border-bottom: 2px solid #f0f0f0; margin: 10px 0 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        tr.head { background-color: #D9EAF7; }
        .btn-merah { background-color: #C0392B; color: white; padding: 8px 15px;
                     border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .notif { padding: 12px 15px; border-radius: 4px; margin-bottom: 15px; }
        .notif-sukses { background: #dff0d8; color: #3c763d; border: 1px solid #c3e0b5; }
        .notif-gagal { background: #f8d7da; color: #a94442; border: 1px solid #f1b0b7; }
        .nav { display: flex; gap: 10px; margin-bottom: 20px; }
        .nav a { background-color: #4682B4; color: white; padding: 8px 15px;
                 text-decoration: none; border-radius: 4px; font-size: 14px; }
        .nav a.aktif { background-color: #E67E22; }
    </style>
</head>
<body>
    <div class="nav">
        <a href="soal2_master_detail.php">Data Transaksi</a>
        <a href="soal3_hapus_barang.php" class="aktif">Data Barang</a>
        <a href="soal4_input_detail_total.php">Input Detail & Total</a>
    </div>

    <p class="judul">Data Barang</p>
    <div class="garis-bawah"></div>

    <?php if ($pesan != "") { ?>
        <div class="notif notif-<?= $tipe ?>"><?= htmlspecialchars($pesan) ?></div>
    <?php } ?>

    <table>
        <tr class="head">
            <th>No</th><th>Kode</th><th>Nama Barang</th><th>Harga</th>
            <th>Stok</th><th>Supplier</th><th>Tindakan</th>
        </tr>
        <?php $no = 1; while ($row = mysqli_fetch_assoc($hasil)) { ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row["kode_barang"]) ?></td>
            <td><?= htmlspecialchars($row["nama_barang"]) ?></td>
            <td>Rp <?= number_format($row["harga"], 0, ',', '.') ?></td>
            <td><?= (int)$row["stok"] ?></td>
            <td><?= htmlspecialchars($row["nama_supplier"] ?? "-") ?></td>
            <td>
                <form method="post" style="margin:0;"
                      onsubmit="return confirm('Anda yakin ingin menghapus barang ini?');">
                    <input type="hidden" name="id_barang" value="<?= (int)$row["id_barang"] ?>">
                    <button type="submit" class="btn-merah">Hapus</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
<?php mysqli_close($koneksi); ?>
