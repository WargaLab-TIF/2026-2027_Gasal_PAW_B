<?php 
require_once "../koneksi.php";
$judul = "Transaksi";
include "../header.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tgl = $_POST['waktu_transaksi'];
    $ket = $_POST['keterangan'];
    $total = 0;
    $pid = $_POST['pelanggan_id'];
    
    $s = mysqli_prepare(
        $koneksi, 
        "INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES (?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($s, "ssis", $tgl, $ket, $total, $pid);
    
    if (mysqli_stmt_execute($s)) {
        header("Location: index.php");
        exit;
    }
    
    $error = mysqli_error($koneksi);
}

$r = mysqli_query($koneksi, "SELECT t.*, p.nama AS pelanggan FROM transaksi t LEFT JOIN pelanggan p ON p.id = t.pelanggan_id ORDER BY t.id DESC");
$p = mysqli_query($koneksi, "SELECT id, nama FROM pelanggan");
?>

<h2>Data Transaksi (Master)</h2>

<?php if (isset($error)) { ?>
    <div class="msg"><?= htmlspecialchars($error) ?></div>
<?php } ?>

<form method="post" class="grid">
    <div>
        <label>Tanggal</label>
        <input type="date" name="waktu_transaksi" required>
    </div>
    <div>
        <label>Pelanggan</label>
        <select name="pelanggan_id" required>
            <?php while ($x = mysqli_fetch_assoc($p)) { ?>
                <option value="<?= $x['id'] ?>"><?= htmlspecialchars($x['nama']) ?></option>
            <?php } ?>
        </select>
    </div>
    <div style="grid-column: 1 / -1">
        <label>Keterangan</label>
        <input name="keterangan">
    </div>
    <div>
        <button class="btn">Buat Transaksi</button>
    </div>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Tanggal</th>
        <th>Pelanggan</th>
        <th>Total</th>
        <th>Detail</th>
    </tr>
    <?php while ($d = mysqli_fetch_assoc($r)) { ?>
        <tr>
            <td><?= $d['id'] ?></td>
            <td><?= $d['waktu_transaksi'] ?></td>
            <td><?= htmlspecialchars($d['pelanggan'] ?? '-') ?></td>
            <td><?= number_format($d['total']) ?></td>
            <td>
                <a class="btn" href="../transaksi_detail/index.php?id=<?= $d['id'] ?>">Kelola Detail</a>
            </td>
        </tr>
    <?php } ?>
</table>

<?php include "../footer.php"; ?>