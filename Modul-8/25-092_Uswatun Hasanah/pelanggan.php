<?php
include 'koneksi.php';
include 'auth.php';
cekOwner();

if (isset($_POST['tambah'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    mysqli_query($conn, "INSERT INTO pelanggan
        (id, nama, jenis_kelamin, telp, alamat)
        VALUES ('$id', '$nama', '$jenis_kelamin', '$telp', '$alamat')");

    header("Location: pelanggan.php");
    exit;
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    mysqli_query($conn, "UPDATE pelanggan SET
        nama='$nama',
        jenis_kelamin='$jenis_kelamin',
        telp='$telp',
        alamat='$alamat'
        WHERE id='$id'");

    header("Location: pelanggan.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    $cek = mysqli_query($conn, "SELECT * FROM transaksi WHERE pelanggan_id='$id'");

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>
            alert('Pelanggan masih memiliki transaksi!');
            window.location='pelanggan.php';
        </script>";
        exit;
    }

    mysqli_query($conn, "DELETE FROM pelanggan WHERE id='$id'");

    header("Location: pelanggan.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM pelanggan");

$edit = null;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $hasil = mysqli_query($conn, "SELECT * FROM pelanggan WHERE id='$id'");
    $edit = mysqli_fetch_assoc($hasil);
}

$namaUser = $_SESSION['nama'] ?: $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pelanggan</title>

    <style>
        body {
            background: #fff5f8;
            font-family: Arial;
            color: #444;
            margin: 30px;
            padding: 20px;
            line-height: 1.6;
        }

        h2 {
            color: #d63384;
        }

        .navbar {
            background: #e879a9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
            font-weight: bold;
        }

        .dropdown {
            display: inline-block;
            position: relative;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background: #e879a9;
            min-width: 150px;
            padding: 10px;
            border-radius: 5px;
            z-index: 10;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu a {
            display: block;
            padding: 5px;
        }

        .container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px #f5d5e3;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            border: 1px solid #edb5cd;
            border-radius: 5px;
            box-sizing: border-box;
            font-family: Arial;
        }

        button, .btn {
            background: #e879a9;
            color: white;
            padding: 9px 14px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            display: inline-block;
        }

        button:hover, .btn:hover {
            background: #d63384;
        }

        .hapus {
            background: #d95380;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th {
            background: #e879a9;
            color: white;
            padding: 12px;
        }

        td {
            border: 1px solid #f5d5e3;
            padding: 10px;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #fff0f5;
        }

        tr:hover {
            background: #fce0eb;
        }
    </style>
</head>

<body>

<div class="navbar">
    <a href="index.php">Home</a>

    <div class="dropdown">
        <a href="#">Data Master ▾</a>
        <div class="dropdown-menu">
            <a href="barang.php">Data Barang</a>
            <a href="supplier.php">Data Supplier</a>
            <a href="pelanggan.php">Data Pelanggan</a>
            <a href="user.php">Data User</a>
        </div>
    </div>

    <a href="detail.php">Transaksi</a>
    <a href="laporan.php">Laporan</a>
    <a href="logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
</div>

<p>Login sebagai: <b><?= htmlspecialchars($namaUser) ?></b></p>

<div class="container">
    <h2><?= $edit ? 'Edit Pelanggan' : 'Tambah Pelanggan' ?></h2>

    <form method="POST">

        <label>ID Pelanggan</label>
        <input type="text" name="id"
            value="<?= htmlspecialchars($edit['id'] ?? '') ?>"
            <?= $edit ? 'readonly' : '' ?> required>

        <label>Nama Pelanggan</label>
        <input type="text" name="nama"
            value="<?= htmlspecialchars($edit['nama'] ?? '') ?>" required>

        <label>Jenis Kelamin</label>
        <select name="jenis_kelamin" required>
            <option value="">Pilih Jenis Kelamin</option>
            <option value="L"
                <?= isset($edit['jenis_kelamin']) && $edit['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>
                Laki-laki
            </option>
            <option value="P"
                <?= isset($edit['jenis_kelamin']) && $edit['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>
                Perempuan
            </option>
        </select>

        <label>Telepon</label>
        <input type="text" name="telp"
            value="<?= htmlspecialchars($edit['telp'] ?? '') ?>">

        <label>Alamat</label>
        <textarea name="alamat" rows="3"><?= htmlspecialchars($edit['alamat'] ?? '') ?></textarea>

        <?php if ($edit) { ?>
            <button type="submit" name="edit">Simpan Perubahan</button>
            <a href="pelanggan.php" class="btn">Batal</a>
        <?php } else { ?>
            <button type="submit" name="tambah">Tambah Pelanggan</button>
        <?php } ?>

    </form>
</div>

<div class="container">
    <h2>Data Pelanggan</h2>

    <table>
        <tr>
            <th>No</th>
            <th>ID Pelanggan</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        while ($p = mysqli_fetch_assoc($data)) {
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($p['id']) ?></td>
            <td><?= htmlspecialchars($p['nama']) ?></td>
            <td>
                <?= $p['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>
            </td>
            <td><?= htmlspecialchars($p['telp']) ?></td>
            <td><?= htmlspecialchars($p['alamat']) ?></td>
            <td>
                <a href="pelanggan.php?edit=<?= urlencode($p['id']) ?>"
                   class="btn">Edit</a>

                <a href="pelanggan.php?hapus=<?= urlencode($p['id']) ?>"
                   class="btn hapus"
                   onclick="return confirm('Hapus pelanggan ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>