<?php
require "fungsi.php"; // sekaligus proteksi login (owner & kasir)

$pesan = '';
$ok = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pelanggan = (int)($_POST['id_pelanggan'] ?? 0);
    $id_buku = (int)($_POST['id_buku'] ?? 0);
    $jumlah = (int)($_POST['jumlah'] ?? 0);

    if (!$id_pelanggan || !$id_buku || $jumlah < 1) {
        $pesan = 'Pelanggan, buku, dan jumlah (minimal 1) wajib diisi';
    } else {
        mysqli_begin_transaction($connect);
        try {
            mysqli_execute_query($connect, "UPDATE buku SET stok = stok - ? WHERE id_buku = ? AND stok >= ?", [$jumlah, $id_buku, $jumlah]);
            if (mysqli_affected_rows($connect) !== 1) {
                throw new Exception('Stok tidak cukup');
            }
            mysqli_execute_query($connect, "INSERT INTO transaksi (id_user, id_pelanggan, id_buku, jumlah) VALUES (?, ?, ?, ?)",
                [$_SESSION['id_user'], $id_pelanggan, $id_buku, $jumlah]);
            mysqli_commit($connect);
            $ok = 'Transaksi berhasil disimpan';
        } catch (Exception $e) {
            mysqli_rollback($connect);
            $pesan = $e instanceof mysqli_sql_exception ? 'Pelanggan atau buku tidak valid' : $e->getMessage();
        }
    }
}

// dibaca setelah proses simpan supaya stok yang tampil sudah terbaru
$pelanggan = mysqli_fetch_all(mysqli_query($connect, "SELECT id_pelanggan, nama FROM pelanggan ORDER BY nama"), MYSQLI_ASSOC);
$buku = mysqli_fetch_all(mysqli_query($connect, "SELECT id_buku, judul, stok FROM buku WHERE stok > 0 ORDER BY judul"), MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Transaksi</title>
</head>
<body>
	<?php include "components/navbar.php" ?>
	<h1>Transaksi</h1>
	<?php if ($ok): ?><p style="color:green"><?= $ok ?></p><?php endif ?>
	<?php if ($pesan): ?><p style="color:red"><?= htmlspecialchars($pesan) ?></p><?php endif ?>

	<form method="post">
		<label>Pelanggan :
			<select name="id_pelanggan" required>
				<option value="">-- pilih --</option>
				<?php foreach ($pelanggan as $p): ?>
				<option value="<?= $p['id_pelanggan'] ?>"><?= htmlspecialchars($p['nama']) ?></option>
				<?php endforeach ?>
			</select>
		</label>
		<br><br>
		<label>Buku :
			<select name="id_buku" required>
				<option value="">-- pilih --</option>
				<?php foreach ($buku as $b): ?>
				<option value="<?= $b['id_buku'] ?>"><?= htmlspecialchars($b['judul']) ?> (stok <?= $b['stok'] ?>)</option>
				<?php endforeach ?>
			</select>
		</label>
		<br><br>
		<label>Jumlah : <input type="number" name="jumlah" min="1" required></label>
		<br><br>
		<button type="submit">Simpan</button>
	</form>
</body>
</html>
