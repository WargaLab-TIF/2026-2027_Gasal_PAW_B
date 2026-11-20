<?php
include 'auth.php';
khususOwner();
include 'koneksi.php';

$pesan = "";

if (isset($_POST['tambah'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jk = $_POST['jenis_kelamin'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $stmt = mysqli_prepare($conn,
        "INSERT INTO pelanggan
        (id, nama, jenis_kelamin, telp, alamat)
        VALUES (?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt, "sssss",
        $id, $nama, $jk, $telp, $alamat
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: pelanggan.php");
        exit;
    } else {
        $pesan = "Gagal menambahkan pelanggan! Periksa ID pelanggan.";
    }
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jk = $_POST['jenis_kelamin'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $stmt = mysqli_prepare($conn,
        "UPDATE pelanggan SET
        nama=?, jenis_kelamin=?, telp=?, alamat=?
        WHERE id=?"
    );

    mysqli_stmt_bind_param(
        $stmt, "sssss",
        $nama, $jk, $telp, $alamat, $id
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: pelanggan.php");
        exit;
    } else {
        $pesan = "Gagal mengedit pelanggan!";
    }
}

if (isset($_POST['hapus'])) {
    $id = $_POST['id'];

    $stmt = mysqli_prepare($conn,
        "DELETE FROM pelanggan WHERE id=?"
    );
    mysqli_stmt_bind_param($stmt, "s", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: pelanggan.php");
        exit;
    } else {
        $pesan = "Pelanggan tidak bisa dihapus karena sudah digunakan dalam transaksi!";
    }
}

$dataEdit = null;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $stmt = mysqli_prepare($conn,
        "SELECT * FROM pelanggan WHERE id=?"
    );
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $dataEdit = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

$dataPelanggan = mysqli_query($conn,
    "SELECT * FROM pelanggan ORDER BY nama ASC"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pelanggan</title>
</head>
<body>

<?php include 'navbar.php'; ?>

<h2>Data Pelanggan</h2>

<p style="color:red;">
    <?= htmlspecialchars($pesan) ?>
</p>

<h3><?= $dataEdit ? "Edit Pelanggan" : "Tambah Pelanggan" ?></h3>

<form method="POST">

    <label>ID Pelanggan</label><br>
    <input type="text" name="id" required
        value="<?= htmlspecialchars($dataEdit['id'] ?? '') ?>"
        <?= $dataEdit ? 'readonly' : '' ?>>
    <br><br>

    <label>Nama Pelanggan</label><br>
    <input type="text" name="nama" required
        value="<?= htmlspecialchars($dataEdit['nama'] ?? '') ?>">
    <br><br>

    <label>Jenis Kelamin</label><br>
    <select name="jenis_kelamin" required>
        <option value="">-- Pilih Jenis Kelamin --</option>

        <option value="L"
            <?= isset($dataEdit['jenis_kelamin']) &&
                $dataEdit['jenis_kelamin'] == 'L'
                ? 'selected' : '' ?>>
            Laki-laki
        </option>

        <option value="P"
            <?= isset($dataEdit['jenis_kelamin']) &&
                $dataEdit['jenis_kelamin'] == 'P'
                ? 'selected' : '' ?>>
            Perempuan
        </option>
    </select>
    <br><br>

    <label>Telepon</label><br>
    <input type="text" name="telp"
        value="<?= htmlspecialchars($dataEdit['telp'] ?? '') ?>">
    <br><br>

    <label>Alamat</label><br>
    <textarea name="alamat"><?= htmlspecialchars($dataEdit['alamat'] ?? '') ?></textarea>
    <br><br>

    <?php if ($dataEdit) { ?>
        <button type="submit" name="edit">Simpan Perubahan</button>
        <a href="pelanggan.php">Batal</a>
    <?php } else { ?>
        <button type="submit" name="tambah">Tambah Pelanggan</button>
    <?php } ?>

</form>

<hr>

<h3>Daftar Pelanggan</h3>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>No</th>
        <th>ID Pelanggan</th>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>Telepon</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>

    <?php $no = 1; ?>
    <?php while ($row = mysqli_fetch_assoc($dataPelanggan)) { ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['id']) ?></td>
        <td><?= htmlspecialchars($row['nama']) ?></td>
        <td>
            <?= $row['jenis_kelamin'] == 'L'
                ? 'Laki-laki' : 'Perempuan' ?>
        </td>
        <td><?= htmlspecialchars($row['telp']) ?></td>
        <td><?= htmlspecialchars($row['alamat']) ?></td>
        <td>
            <a href="pelanggan.php?edit=<?= urlencode($row['id']) ?>">
                Edit
            </a>

            <form method="POST" style="display:inline;"
                onsubmit="return confirm('Yakin ingin menghapus pelanggan?')">
                <input type="hidden" name="id"
                    value="<?= htmlspecialchars($row['id']) ?>">
                <button type="submit" name="hapus">Hapus</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>