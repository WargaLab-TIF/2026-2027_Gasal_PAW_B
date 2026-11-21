<?php
// CRUD generik khusus owner. Halaman pemanggil mengisi: $tabel, $pk, $judul, $kolom, (opsional) $unik.
// $kolom: field => ['label' => .., 'type' => 'text|password|select', 'opsi' => [nilai => teks]]
$hanya_owner = true;
require "fungsi.php";

function h($s) { return htmlspecialchars($s ?? ''); }

$aksi = $_GET['aksi'] ?? '';
$id = (int)($_GET['id'] ?? 0);
$self = basename($_SERVER['PHP_SELF']);
$post = $_SERVER['REQUEST_METHOD'] === 'POST';
$error = [];
$nilai = [];
$pesan = '';

if ($post && $aksi === 'hapus') {
    if ($tabel === 'user' && $id == $_SESSION['id_user']) {
        $pesan = 'Tidak bisa menghapus akun yang sedang login';
    } else {
        try {
            mysqli_execute_query($connect, "DELETE FROM $tabel WHERE $pk = ?", [$id]);
            header("Location: $self");
            exit();
        } catch (mysqli_sql_exception $e) {
            $pesan = 'Data masih dipakai di transaksi, tidak bisa dihapus';
        }
    }
    $aksi = '';
}

if ($post && ($aksi === 'tambah' || $aksi === 'edit')) {
    foreach ($kolom as $f => $k) {
        $tipe = $k['type'] ?? 'text';
        $nilai[$f] = trim($_POST[$f] ?? '');
        if ($nilai[$f] === '') {
            // password boleh kosong saat edit (tidak diubah)
            if (!($tipe === 'password' && $aksi === 'edit')) $error[$f] = $k['label'] . ' wajib diisi';
        } elseif ($tipe === 'select' && !isset($k['opsi'][$nilai[$f]])) {
            $error[$f] = $k['label'] . ' tidak valid';
        }
    }

    if (isset($unik) && !isset($error[$unik])
        && mysqli_fetch_row(mysqli_execute_query($connect, "SELECT 1 FROM $tabel WHERE $unik = ? AND $pk <> ?", [$nilai[$unik], $id]))) {
        $error[$unik] = $kolom[$unik]['label'] . ' sudah dipakai';
    }

    if (!$error) {
        $set = [];
        $val = [];
        foreach ($kolom as $f => $k) {
            $v = $nilai[$f];
            if (($k['type'] ?? 'text') === 'password') {
                if ($v === '') continue;
                $v = md5($v); // harus sama dengan proses verifikasi di login.php
            }
            $set[] = $f;
            $val[] = $v;
        }
        if ($aksi === 'tambah') {
            $sql = "INSERT INTO $tabel (" . implode(',', $set) . ") VALUES (" . implode(',', array_fill(0, count($set), '?')) . ")";
        } else {
            $sql = "UPDATE $tabel SET " . implode('=?,', $set) . "=? WHERE $pk = ?";
            $val[] = $id;
        }
        mysqli_execute_query($connect, $sql, $val);
        header("Location: $self");
        exit();
    }
}

if ($aksi === 'edit' && !$post) {
    $row = mysqli_fetch_assoc(mysqli_execute_query($connect, "SELECT * FROM $tabel WHERE $pk = ?", [$id]));
    if (!$row) {
        header("Location: $self");
        exit();
    }
    foreach ($kolom as $f => $k) {
        $nilai[$f] = ($k['type'] ?? 'text') === 'password' ? '' : $row[$f];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= h($judul) ?></title>
</head>
<body>
	<?php include "components/navbar.php" ?>
	<h1><?= h($judul) ?></h1>
	<?php if ($pesan): ?><p style="color:red"><?= h($pesan) ?></p><?php endif ?>

	<?php if ($aksi === 'tambah' || $aksi === 'edit'): ?>
	<form method="post">
		<?php foreach ($kolom as $f => $k): $tipe = $k['type'] ?? 'text'; ?>
			<label><?= h($k['label']) ?> :
			<?php if ($tipe === 'select'): ?>
				<select name="<?= $f ?>">
					<option value="">-- pilih --</option>
					<?php foreach ($k['opsi'] as $v => $t): ?>
					<option value="<?= h($v) ?>" <?= ($nilai[$f] ?? '') == $v ? 'selected' : '' ?>><?= h($t) ?></option>
					<?php endforeach ?>
				</select>
			<?php else: ?>
				<input type="<?= $tipe ?>" name="<?= $f ?>" value="<?= h($nilai[$f] ?? '') ?>"
					<?= $tipe === 'password' && $aksi === 'edit' ? 'placeholder="kosongkan jika tidak diubah"' : '' ?>>
			<?php endif ?>
			</label>
			<span style="color:red"><?= h($error[$f] ?? '') ?></span>
			<br><br>
		<?php endforeach ?>
		<button type="submit">Simpan</button>
		<a href="<?= $self ?>">Batal</a>
	</form>

	<?php else: ?>
	<a href="<?= $self ?>?aksi=tambah">+ Tambah</a>
	<br><br>
	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<?php foreach ($kolom as $k): if (($k['type'] ?? 'text') === 'password') continue; ?>
				<th><?= h($k['label']) ?></th>
			<?php endforeach ?>
			<th>Aksi</th>
		</tr>
		<?php foreach (mysqli_query($connect, "SELECT * FROM $tabel ORDER BY $pk") as $row): ?>
		<tr>
			<?php foreach ($kolom as $f => $k): if (($k['type'] ?? 'text') === 'password') continue; ?>
				<td><?= h($k['opsi'][$row[$f]] ?? $row[$f]) ?></td>
			<?php endforeach ?>
			<td>
				<a href="<?= $self ?>?aksi=edit&id=<?= $row[$pk] ?>">Edit</a> |
				<form method="post" action="<?= $self ?>?aksi=hapus&id=<?= $row[$pk] ?>" style="display:inline" onsubmit="return confirm('Hapus data ini?')">
					<button type="submit">Hapus</button>
				</form>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
	<?php endif ?>
</body>
</html>
