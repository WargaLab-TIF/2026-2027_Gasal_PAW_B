
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['level'] != 1) {
    header("Location: index.php");
    exit;
}

include 'koneksi.php';

// Proses tambah pelanggan
if (isset($_POST['tambah'])) {
    $id = mysqli_real_escape_string($koneksi, $_POST['id']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $telp = mysqli_real_escape_string($koneksi, $_POST['telp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    mysqli_query($koneksi, "INSERT INTO pelanggan
        (id, nama, jenis_kelamin, telp, alamat)
        VALUES ('$id', '$nama', '$jenis_kelamin', '$telp', '$alamat')");

    header("Location: pelanggan.php");
    exit;
}

// Proses edit pelanggan
if (isset($_POST['edit'])) {
    $id = mysqli_real_escape_string($koneksi, $_POST['id']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $telp = mysqli_real_escape_string($koneksi, $_POST['telp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    mysqli_query($koneksi, "UPDATE pelanggan SET
        nama='$nama',
        jenis_kelamin='$jenis_kelamin',
        telp='$telp',
        alamat='$alamat'
        WHERE id='$id'");

    header("Location: pelanggan.php");
    exit;
}

// Proses hapus pelanggan
if (isset($_GET['hapus'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['hapus']);

    $cek = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE pelanggan_id='$id'");

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>
            alert('Pelanggan tidak bisa dihapus karena masih digunakan dalam transaksi!');
            window.location='pelanggan.php';
        </script>";
        exit;
    }

    mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id='$id'");

    header("Location: pelanggan.php");
    exit;
}

// Data pelanggan yang akan diedit
$data_edit = null;

if (isset($_GET['edit'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['edit']);
    $hasil_edit = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id='$id'");
    $data_edit = mysqli_fetch_assoc($hasil_edit);
}

// Query data pelanggan
$query = mysqli_query($koneksi, "SELECT * FROM pelanggan");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pelanggan</title>

    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f5f4fa;
            padding: 30px;
            color: #252b40;
        }

        h1, h2 {
            color: #493b78;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }

        th {
            background: #493b78;
            color: white;
            padding: 12px;
        }

        td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #eeeaf5;
        }

        a, button {
            display: inline-block;
            color: white;
            background: #8064c8;
            padding: 9px 15px;
            border-radius: 7px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        a:hover, button:hover {
            background: #6248a5;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 7px;
        }

        .form {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
        }

        nav {
            background: #493b78;
            padding: 12px;
            border-radius: 8px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        nav a {
            background: #8064c8;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background: white;
            min-width: 160px;
            top: 100%;
            left: 0;
            z-index: 10;
        }

        .dropdown-content a {
            display: block;
            color: #493b78;
            background: white;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .logout {
            margin-left: auto;
            color: white;
            display: flex;
            gap: 10px;
            align-items: center;
        }
    </style>
</head>

<body>

<h1>APLIKASI PENJUALAN</h1>

<nav>
    <a href="index.php">Home</a>

    <div class="dropdown">
        <a href="#">Data Master</a>
        <div class="dropdown-content">
            <a href="barang.php">Data Barang</a>
            <a href="supplier.php">Data Supplier</a>
            <a href="pelanggan.php">Data Pelanggan</a>
            <a href="user.php">Data User</a>
        </div>
    </div>

    <a href="transaksi.php">Transaksi</a>
    <a href="laporan.php">Laporan</a>

    <div class="logout">
        <span>Halo, <?= $_SESSION['nama']; ?></span>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<h2>Data Pelanggan</h2>

<div class="form">
    <h3><?= $data_edit ? 'Edit Pelanggan' : 'Tambah Pelanggan'; ?></h3>

    <form method="POST">
        <label>ID Pelanggan</label>
        <input type="text" name="id"
            value="<?= $data_edit ? $data_edit['id'] : ''; ?>"
            <?= $data_edit ? 'readonly' : ''; ?>
            required>

        <label>Nama Pelanggan</label>
        <input type="text" name="nama"
            value="<?= $data_edit ? $data_edit['nama'] : ''; ?>"
            required>

        <label>Jenis Kelamin</label>
        <select name="jenis_kelamin" required>
            <option value="">-- Pilih --</option>
            <option value="L"
                <?= ($data_edit && $data_edit['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>
                Laki-laki
            </option>
            <option value="P"
                <?= ($data_edit && $data_edit['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>
                Perempuan
            </option>
        </select>

        <label>Telp</label>
        <input type="text" name="telp"
            value="<?= $data_edit ? $data_edit['telp'] : ''; ?>"
            required>

        <label>Alamat</label>
        <textarea name="alamat" required><?= $data_edit ? $data_edit['alamat'] : ''; ?></textarea>

        <?php if ($data_edit) { ?>
            <button type="submit" name="edit">Simpan Edit</button>
            <a href="pelanggan.php">Batal</a>
        <?php } else { ?>
            <button type="submit" name="tambah">Tambah Pelanggan</button>
        <?php } ?>
    </form>
</div>

<table>
    <tr>
        <th>No</th>
        <th>ID</th>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>Telp</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>

    <?php
    $no = 1;
    while ($data = mysqli_fetch_assoc($query)) {
    ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['id']; ?></td>
            <td><?= $data['nama']; ?></td>
            <td><?= $data['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
            <td><?= $data['telp']; ?></td>
            <td><?= $data['alamat']; ?></td>
            <td>
                <a href="pelanggan.php?edit=<?= $data['id']; ?>">Edit</a>
                <a href="pelanggan.php?hapus=<?= $data['id']; ?>"
                   onclick="return confirm('Yakin ingin menghapus pelanggan ini?')">
                   Hapus
                </a>
            </td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
