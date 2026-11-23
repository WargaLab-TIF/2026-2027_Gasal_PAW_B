<?php
include 'koneksi.php';
include 'auth.php';
cekOwner();

if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $hp = $_POST['hp'];
    $level = $_POST['level'];

    mysqli_query($conn, "INSERT INTO user
        (username, password, nama, alamat, hp, level)
        VALUES ('$username', '$password', '$nama', '$alamat', '$hp', '$level')");

    header("Location: user.php");
    exit;
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $hp = $_POST['hp'];
    $level = $_POST['level'];

    if ($_POST['password'] != '') {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        mysqli_query($conn, "UPDATE user SET password='$password'
            WHERE id_user='$id'");
    }

    mysqli_query($conn, "UPDATE user SET
        username='$username',
        nama='$nama',
        alamat='$alamat',
        hp='$hp',
        level='$level'
        WHERE id_user='$id'");

    header("Location: user.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    if ($id == $_SESSION['id_user']) {
        echo "<script>
            alert('Anda tidak bisa menghapus akun sendiri!');
            window.location='user.php';
        </script>";
        exit;
    }

    mysqli_query($conn, "DELETE FROM user WHERE id_user='$id'");

    header("Location: user.php");
    exit;
}

$edit = null;

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $hasil = mysqli_query($conn, "SELECT * FROM user WHERE id_user='$id'");
    $edit = mysqli_fetch_assoc($hasil);
}

$data = mysqli_query($conn, "SELECT * FROM user");

$namaUser = $_SESSION['nama'] ?: $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>

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

        input, select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            border: 1px solid #edb5cd;
            border-radius: 5px;
            box-sizing: border-box;
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
    <h2><?= $edit ? 'Edit User' : 'Tambah User' ?></h2>

    <form method="POST">

        <input type="hidden" name="id"
            value="<?= $edit['id_user'] ?? '' ?>">

        <label>Username</label>
        <input type="text" name="username"
            value="<?= htmlspecialchars($edit['username'] ?? '') ?>" required>

        <label>Password</label>
        <input type="password" name="password"
            <?= $edit ? '' : 'required' ?>
            placeholder="<?= $edit ? 'Kosongkan jika tidak diubah' : 'Masukkan password' ?>">

        <label>Nama</label>
        <input type="text" name="nama"
            value="<?= htmlspecialchars($edit['nama'] ?? '') ?>" required>

        <label>Alamat</label>
        <input type="text" name="alamat"
            value="<?= htmlspecialchars($edit['alamat'] ?? '') ?>">

        <label>No HP</label>
        <input type="text" name="hp"
            value="<?= htmlspecialchars($edit['hp'] ?? '') ?>">

        <label>Level</label>
        <select name="level" required>
            <option value="1" <?= ($edit['level'] ?? '') == 1 ? 'selected' : '' ?>>
                Owner
            </option>
            <option value="2" <?= ($edit['level'] ?? '') == 2 ? 'selected' : '' ?>>
                Kasir
            </option>
        </select>

        <?php if ($edit) { ?>
            <button type="submit" name="edit">Simpan Perubahan</button>
            <a href="user.php" class="btn">Batal</a>
        <?php } else { ?>
            <button type="submit" name="tambah">Tambah User</button>
        <?php } ?>

    </form>
</div>

<div class="container">
    <h2>Data User</h2>

    <table>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>No HP</th>
            <th>Level</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        while ($u = mysqli_fetch_assoc($data)) {
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($u['username']) ?></td>
            <td><?= htmlspecialchars($u['nama']) ?></td>
            <td><?= htmlspecialchars($u['alamat']) ?></td>
            <td><?= htmlspecialchars($u['hp']) ?></td>
            <td><?= $u['level'] == 1 ? 'Owner' : 'Kasir' ?></td>
            <td>
                <a href="user.php?edit=<?= $u['id_user'] ?>"
                   class="btn">Edit</a>

                <a href="user.php?hapus=<?= $u['id_user'] ?>"
                   class="btn hapus"
                   onclick="return confirm('Hapus user ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
