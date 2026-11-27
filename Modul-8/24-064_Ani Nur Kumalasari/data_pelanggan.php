<?php
include "validasi.php";
include "koneksi.php";

wajib_owner();

$pesan = "";

// PROSES TAMBAH PELANGGAN
if (isset($_POST['tambah'])) {

    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
    $telp = mysqli_real_escape_string($koneksi, $_POST['telp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    $query = mysqli_query($koneksi, "
        INSERT INTO pelanggan (nama_pelanggan, telp, alamat)
        VALUES ('$nama', '$telp', '$alamat')
    ");

    if ($query) {
        header("Location: data_pelanggan.php?status=tambah");
        exit;
    } else {
        $pesan = "Gagal menambahkan pelanggan: " . mysqli_error($koneksi);
    }
}

// PROSES EDIT PELANGGAN
if (isset($_POST['edit'])) {

    $id = (int) $_POST['id_pelanggan'];
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
    $telp = mysqli_real_escape_string($koneksi, $_POST['telp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    $query = mysqli_query($koneksi, "
        UPDATE pelanggan
        SET nama_pelanggan = '$nama',
            telp = '$telp',
            alamat = '$alamat'
        WHERE id_pelanggan = $id
    ");

    if ($query) {
        header("Location: data_pelanggan.php?status=edit");
        exit;
    } else {
        $pesan = "Gagal mengubah pelanggan: " . mysqli_error($koneksi);
    }
}

// PROSES HAPUS PELANGGAN
if (isset($_GET['hapus'])) {

    $id = (int) $_GET['hapus'];

    $query = mysqli_query($koneksi, "
        DELETE FROM pelanggan
        WHERE id_pelanggan = $id
    ");

    if ($query) {
        header("Location: data_pelanggan.php?status=hapus");
        exit;
    } else {
        $pesan = "Pelanggan tidak dapat dihapus karena mungkin sudah digunakan dalam transaksi.";
    }
}

// MENGAMBIL DATA PELANGGAN UNTUK DIEDIT
$data_edit = null;

if (isset($_GET['edit'])) {

    $id = (int) $_GET['edit'];

    $result_edit = mysqli_query($koneksi, "
        SELECT * FROM pelanggan
        WHERE id_pelanggan = $id
    ");

    $data_edit = mysqli_fetch_assoc($result_edit);
}

// MENAMPILKAN DATA PELANGGAN
$query = mysqli_query($koneksi, "
    SELECT * FROM pelanggan
    ORDER BY id_pelanggan ASC
");

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pelanggan</title>
    <link rel="stylesheet" href="style.css">

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
            width: 450px;
            margin: 25px 0;
        }

        label {
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 9px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
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

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #39758d;
            color: white;
        }

        .edit {
            color: #ed6b16;
            text-decoration: none;
        }

        .hapus {
            color: #c82333;
            text-decoration: none;
        }

        .pesan {
            color: green;
        }
    </style>
</head>

<body>

<h2>Data Master Pelanggan</h2>

<a href="index.php">Home</a>

<?php
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'tambah') {
        echo "<p class='pesan'>Pelanggan berhasil ditambahkan.</p>";
    } elseif ($_GET['status'] == 'edit') {
        echo "<p class='pesan'>Pelanggan berhasil diubah.</p>";
    } elseif ($_GET['status'] == 'hapus') {
        echo "<p class='pesan'>Pelanggan berhasil dihapus.</p>";
    }
}

if ($pesan != "") {
    echo "<p style='color:red;'>" . htmlspecialchars($pesan) . "</p>";
}
?>

<h3>
    <?= $data_edit ? "Edit Pelanggan" : "Tambah Pelanggan"; ?>
</h3>

<form method="POST" class="form">

    <?php if ($data_edit) { ?>
        <input type="hidden" name="id_pelanggan"
               value="<?= $data_edit['id_pelanggan']; ?>">
    <?php } ?>

    <label>Nama Pelanggan</label><br><br>

    <input type="text" name="nama_pelanggan"
           value="<?= htmlspecialchars($data_edit['nama_pelanggan'] ?? ''); ?>"
           required>

    <br><br>

    <label>Telepon</label><br><br>

    <input type="text" name="telp"
           value="<?= htmlspecialchars($data_edit['telp'] ?? ''); ?>"
           required>

    <br><br>

    <label>Alamat</label><br><br>

    <textarea name="alamat" rows="3" required><?= htmlspecialchars($data_edit['alamat'] ?? ''); ?></textarea>

    <br><br>

    <?php if ($data_edit) { ?>

        <button type="submit" name="edit">Simpan Perubahan</button>

        <a href="data_pelanggan.php" class="batal">Batal</a>

    <?php } else { ?>

        <button type="submit" name="tambah">Tambah Pelanggan</button>

    <?php } ?>

</form>

<h3>Daftar Pelanggan</h3>

<table>

<tr>
    <th>ID</th>
    <th>Nama Pelanggan</th>
    <th>Telepon</th>
    <th>Alamat</th>
    <th>Aksi</th>
</tr>

<?php while ($p = mysqli_fetch_assoc($query)) { ?>

<tr>
    <td><?= $p['id_pelanggan']; ?></td>

    <td><?= htmlspecialchars($p['nama_pelanggan']); ?></td>

    <td><?= htmlspecialchars($p['telp']); ?></td>

    <td><?= htmlspecialchars($p['alamat']); ?></td>

    <td>
        <a class="edit"
           href="data_pelanggan.php?edit=<?= $p['id_pelanggan']; ?>">
           Edit
        </a>

        |

        <a class="hapus"
           href="data_pelanggan.php?hapus=<?= $p['id_pelanggan']; ?>"
           onclick="return confirm('Yakin ingin menghapus pelanggan ini?')">
           Hapus
        </a>
    </td>
</tr>

<?php } ?>

</table>

</body>
</html>
