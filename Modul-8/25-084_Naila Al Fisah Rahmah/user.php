
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

// Proses tambah user
if (isset($_POST['tambah'])) {
    $id_user = $_POST['id_user'];
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $HP = mysqli_real_escape_string($koneksi, $_POST['HP']);
    $LEVEL = $_POST['LEVEL'];

    mysqli_query($koneksi, "INSERT INTO users
        (id_user, username, password, nama, alamat, HP, LEVEL)
        VALUES
        ('$id_user', '$username', '$password', '$nama', '$alamat', '$HP', '$LEVEL')");

    header("Location: user.php");
    exit;
}

// Proses edit user
if (isset($_POST['edit'])) {
    $id_user = $_POST['id_user'];
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $HP = mysqli_real_escape_string($koneksi, $_POST['HP']);
    $LEVEL = $_POST['LEVEL'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        mysqli_query($koneksi, "UPDATE users SET
            username='$username',
            password='$password',
            nama='$nama',
            alamat='$alamat',
            HP='$HP',
            LEVEL='$LEVEL'
            WHERE id_user='$id_user'");
    } else {
        mysqli_query($koneksi, "UPDATE users SET
            username='$username',
            nama='$nama',
            alamat='$alamat',
            HP='$HP',
            LEVEL='$LEVEL'
            WHERE id_user='$id_user'");
    }

    header("Location: user.php");
    exit;
}

// Proses hapus user
if (isset($_GET['hapus'])) {
    $id_user = $_GET['hapus'];

    // Mencegah user menghapus akun yang sedang digunakan
    if ($id_user == $_SESSION['id_user']) {
        echo "<script>
            alert('Akun yang sedang digunakan tidak bisa dihapus!');
            window.location='user.php';
        </script>";
        exit;
    }

    mysqli_query($koneksi, "DELETE FROM users WHERE id_user='$id_user'");

    header("Location: user.php");
    exit;
}

// Data user yang akan diedit
$data_edit = null;

if (isset($_GET['edit'])) {
    $id_user = $_GET['edit'];
    $hasil_edit = mysqli_query($koneksi, "SELECT * FROM users WHERE id_user='$id_user'");
    $data_edit = mysqli_fetch_assoc($hasil_edit);
}

// Query data user
$query = mysqli_query($koneksi, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>

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

<h2>Data User</h2>

<div class="form">
    <h3><?= $data_edit ? 'Edit User' : 'Tambah User'; ?></h3>

    <form method="POST">
        <label>ID User</label>
        <input type="number" name="id_user"
            value="<?= $data_edit ? $data_edit['id_user'] : ''; ?>"
            <?= $data_edit ? 'readonly' : ''; ?>
            required>

        <label>Username</label>
        <input type="text" name="username"
            value="<?= $data_edit ? $data_edit['username'] : ''; ?>"
            required>

        <label>Password</label>
        <input type="password" name="password"
            <?= $data_edit ? '' : 'required'; ?>
            placeholder="<?= $data_edit ? 'Kosongkan jika tidak diubah' : 'Masukkan password'; ?>">

        <label>Nama</label>
        <input type="text" name="nama"
            value="<?= $data_edit ? $data_edit['nama'] : ''; ?>"
            required>

        <label>Alamat</label>
        <textarea name="alamat" required><?= $data_edit ? $data_edit['alamat'] : ''; ?></textarea>

        <label>HP</label>
        <input type="text" name="HP"
            value="<?= $data_edit ? $data_edit['HP'] : ''; ?>"
            required>

        <label>Level</label>
        <select name="LEVEL" required>
            <option value="">-- Pilih Level --</option>

            <option value="1"
                <?= ($data_edit && $data_edit['LEVEL'] == 1) ? 'selected' : ''; ?>>
                Owner (Level 1)
            </option>

            <option value="2"
                <?= ($data_edit && $data_edit['LEVEL'] == 2) ? 'selected' : ''; ?>>
                Kasir (Level 2)
            </option>
        </select>

        <?php if ($data_edit) { ?>
            <button type="submit" name="edit">Simpan Edit</button>
            <a href="user.php">Batal</a>
        <?php } else { ?>
            <button type="submit" name="tambah">Tambah User</button>
        <?php } ?>
    </form>
</div>

<table>
    <tr>
        <th>No</th>
        <th>ID User</th>
        <th>Username</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>HP</th>
        <th>Level</th>
        <th>Aksi</th>
    </tr>

    <?php
    $no = 1;
    while ($data = mysqli_fetch_assoc($query)) {
    ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['id_user']; ?></td>
            <td><?= $data['username']; ?></td>
            <td><?= $data['nama']; ?></td>
            <td><?= $data['alamat']; ?></td>
            <td><?= $data['HP']; ?></td>
            <td><?= $data['LEVEL'] == 1 ? 'Owner' : 'Kasir'; ?></td>
            <td>
                <a href="user.php?edit=<?= $data['id_user']; ?>">Edit</a>

                <a href="user.php?hapus=<?= $data['id_user']; ?>"
                   onclick="return confirm('Yakin ingin menghapus user ini?')">
                   Hapus
                </a>
            </td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
