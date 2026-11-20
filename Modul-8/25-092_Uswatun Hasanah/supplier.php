<?php
include 'koneksi.php';
include 'auth.php';
cekOwner();

if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    mysqli_query($conn, "INSERT INTO supplier (nama, telp, alamat)
        VALUES ('$nama', '$telp', '$alamat')");

    header("Location: supplier.php");
    exit;
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    mysqli_query($conn, "UPDATE supplier SET
        nama='$nama', telp='$telp', alamat='$alamat'
        WHERE id='$id'");

    header("Location: supplier.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    $cek = mysqli_query($conn, "SELECT * FROM barang WHERE supplier_id='$id'");

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Supplier masih digunakan!'); window.location='supplier.php';</script>";
        exit;
    } else {
        mysqli_query($conn, "DELETE FROM supplier WHERE id='$id'");
        header("Location: supplier.php");
        exit;
    }
}

$data = mysqli_query($conn, "SELECT * FROM supplier");

$edit = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $hasil = mysqli_query($conn, "SELECT * FROM supplier WHERE id='$id'");
    $edit = mysqli_fetch_assoc($hasil);
}

$level = (int)$_SESSION['level'];
$namaUser = $_SESSION['nama'] ?: $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Supplier</title>

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

        .navbar a:hover {
            color: #fff0f5;
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

        input, textarea {
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
    <h2><?= $edit ? 'Edit Supplier' : 'Tambah Supplier' ?></h2>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">

        <label>Nama Supplier</label>
        <input type="text" name="nama"
            value="<?= htmlspecialchars($edit['nama'] ?? '') ?>" required>

        <label>Telepon</label>
        <input type="text" name="telp"
            value="<?= htmlspecialchars($edit['telp'] ?? '') ?>">

        <label>Alamat</label>
        <textarea name="alamat" rows="3"><?= htmlspecialchars($edit['alamat'] ?? '') ?></textarea>

        <?php if ($edit) { ?>
            <button type="submit" name="edit">Simpan Perubahan</button>
            <a href="supplier.php" class="btn">Batal</a>
        <?php } else { ?>
            <button type="submit" name="tambah">Tambah Supplier</button>
        <?php } ?>
    </form>
</div>

<div class="container">
    <h2>Data Supplier</h2>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        while ($s = mysqli_fetch_assoc($data)) {
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($s['nama']) ?></td>
            <td><?= htmlspecialchars($s['telp']) ?></td>
            <td><?= htmlspecialchars($s['alamat']) ?></td>
            <td>
                <a href="supplier.php?edit=<?= $s['id'] ?>" class="btn">Edit</a>

                <a href="supplier.php?hapus=<?= $s['id'] ?>"
                   class="btn hapus"
                   onclick="return confirm('Hapus supplier ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
