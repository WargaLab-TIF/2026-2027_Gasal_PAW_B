
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

// Proses tambah supplier
if (isset($_POST['tambah'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $telp = mysqli_real_escape_string($koneksi, $_POST['telp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    mysqli_query($koneksi, "INSERT INTO supplier (nama, telp, alamat)
                            VALUES ('$nama', '$telp', '$alamat')");

    header("Location: supplier.php");
    exit;
}

// Proses edit supplier
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $telp = mysqli_real_escape_string($koneksi, $_POST['telp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    mysqli_query($koneksi, "UPDATE supplier SET
                            nama='$nama',
                            telp='$telp',
                            alamat='$alamat'
                            WHERE id='$id'");

    header("Location: supplier.php");
    exit;
}

// Proses hapus supplier
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    $cek = mysqli_query($koneksi, "SELECT * FROM barang WHERE supplier_id='$id'");

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>
            alert('Supplier tidak bisa dihapus karena masih digunakan oleh barang!');
            window.location='supplier.php';
        </script>";
        exit;
    }

    mysqli_query($koneksi, "DELETE FROM supplier WHERE id='$id'");

    header("Location: supplier.php");
    exit;
}

// Data supplier yang akan diedit
$data_edit = null;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $hasil_edit = mysqli_query($koneksi, "SELECT * FROM supplier WHERE id='$id'");
    $data_edit = mysqli_fetch_assoc($hasil_edit);
}

// Query data supplier
$query = mysqli_query($koneksi, "SELECT * FROM supplier");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Supplier</title>

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

        input, textarea {
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

<h2>Data Supplier</h2>

<div class="form">
    <h3><?= $data_edit ? 'Edit Supplier' : 'Tambah Supplier'; ?></h3>

    <form method="POST">
        <?php if ($data_edit) { ?>
            <input type="hidden" name="id" value="<?= $data_edit['id']; ?>">
        <?php } ?>

        <label>Nama Supplier</label>
        <input type="text" name="nama"
            value="<?= $data_edit ? $data_edit['nama'] : ''; ?>"
            required>

        <label>Telp</label>
        <input type="text" name="telp"
            value="<?= $data_edit ? $data_edit['telp'] : ''; ?>"
            required>

        <label>Alamat</label>
        <textarea name="alamat" required><?= $data_edit ? $data_edit['alamat'] : ''; ?></textarea>

        <?php if ($data_edit) { ?>
            <button type="submit" name="edit">Simpan Edit</button>
            <a href="supplier.php">Batal</a>
        <?php } else { ?>
            <button type="submit" name="tambah">Tambah Supplier</button>
        <?php } ?>
    </form>
</div>

<table>
    <tr>
        <th>No</th>
        <th>Nama</th>
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
            <td><?= $data['nama']; ?></td>
            <td><?= $data['telp']; ?></td>
            <td><?= $data['alamat']; ?></td>
            <td>
                <a href="supplier.php?edit=<?= $data['id']; ?>">Edit</a>
                <a href="supplier.php?hapus=<?= $data['id']; ?>"
                   onclick="return confirm('Yakin ingin menghapus supplier ini?')">
                   Hapus
                </a>
            </td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
