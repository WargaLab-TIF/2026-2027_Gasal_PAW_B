<?php
include "validasi.php";
include "koneksi.php";

wajib_owner();

$pesan = "";

// PROSES TAMBAH USER
if (isset($_POST['tambah'])) {

    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']);
    $level = (int) $_POST['level'];

    // Cek username agar tidak duplikat
    $cek = mysqli_query($koneksi, "
        SELECT * FROM user WHERE username = '$username'
    ");

    if (mysqli_num_rows($cek) > 0) {
        $pesan = "Username sudah digunakan.";
    } else {

        $query = mysqli_query($koneksi, "
            INSERT INTO user (nama, username, password, level)
            VALUES ('$nama', '$username', '$password', $level)
        ");

        if ($query) {
            header("Location: data_user.php?status=tambah");
            exit;
        } else {
            $pesan = "Gagal menambahkan user: " . mysqli_error($koneksi);
        }
    }
}

// PROSES EDIT USER
if (isset($_POST['edit'])) {

    $id = (int) $_POST['id_user'];
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $level = (int) $_POST['level'];

    $cek = mysqli_query($koneksi, "
        SELECT id_user FROM user
        WHERE username = '$username'
        AND id_user != $id
    ");

    if (mysqli_num_rows($cek) > 0) {
        $pesan = "Username sudah digunakan user lain.";
    } else {

        // Password hanya diubah jika diisi
        if (!empty($_POST['password'])) {

            $password = md5($_POST['password']);

            $query = mysqli_query($koneksi, "
                UPDATE user
                SET nama = '$nama',
                    username = '$username',
                    password = '$password',
                    level = $level
                WHERE id_user = $id
            ");

        } else {

            $query = mysqli_query($koneksi, "
                UPDATE user
                SET nama = '$nama',
                    username = '$username',
                    level = $level
                WHERE id_user = $id
            ");
        }

        if ($query) {
            header("Location: data_user.php?status=edit");
            exit;
        } else {
            $pesan = "Gagal mengubah user: " . mysqli_error($koneksi);
        }
    }
}

// PROSES HAPUS USER
if (isset($_GET['hapus'])) {

    $id = (int) $_GET['hapus'];

    // Tidak boleh menghapus akun yang sedang login
    if ($id == $_SESSION['id_user']) {

        $pesan = "Akun yang sedang digunakan tidak dapat dihapus.";

    } else {

        $query = mysqli_query($koneksi, "
            DELETE FROM user
            WHERE id_user = $id
        ");

        if ($query) {
            header("Location: data_user.php?status=hapus");
            exit;
        } else {
            $pesan = "User tidak dapat dihapus karena mungkin sudah digunakan dalam transaksi.";
        }
    }
}

// MENGAMBIL DATA USER UNTUK DIEDIT
$data_edit = null;

if (isset($_GET['edit'])) {

    $id = (int) $_GET['edit'];

    $result_edit = mysqli_query($koneksi, "
        SELECT * FROM user
        WHERE id_user = $id
    ");

    $data_edit = mysqli_fetch_assoc($result_edit);
}

// MENAMPILKAN SELURUH USER
$query = mysqli_query($koneksi, "
    SELECT id_user, nama, username, level
    FROM user
    ORDER BY id_user ASC
");

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
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

        input, select {
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

<h2>Data Master User</h2>

<a href="index.php">Home</a>

<?php
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'tambah') {
        echo "<p class='pesan'>User berhasil ditambahkan.</p>";
    } elseif ($_GET['status'] == 'edit') {
        echo "<p class='pesan'>User berhasil diubah.</p>";
    } elseif ($_GET['status'] == 'hapus') {
        echo "<p class='pesan'>User berhasil dihapus.</p>";
    }
}

if ($pesan != "") {
    echo "<p style='color:red;'>" . htmlspecialchars($pesan) . "</p>";
}
?>

<h3>
    <?= $data_edit ? "Edit User" : "Tambah User"; ?>
</h3>

<form method="POST" class="form">

    <?php if ($data_edit) { ?>
        <input type="hidden" name="id_user"
               value="<?= $data_edit['id_user']; ?>">
    <?php } ?>

    <label>Nama</label><br><br>

    <input type="text" name="nama"
           value="<?= htmlspecialchars($data_edit['nama'] ?? ''); ?>"
           required>

    <br><br>

    <label>Username</label><br><br>

    <input type="text" name="username"
           value="<?= htmlspecialchars($data_edit['username'] ?? ''); ?>"
           required>

    <br><br>

    <label>Password</label><br><br>

    <input type="password" name="password"
           <?= $data_edit ? '' : 'required'; ?>
           placeholder="<?= $data_edit ? 'Kosongkan jika tidak ingin mengubah password' : 'Masukkan password'; ?>">

    <br><br>

    <label>Level</label><br><br>

    <select name="level" required>
        <option value="1"
            <?= isset($data_edit) && $data_edit['level'] == 1 ? 'selected' : ''; ?>>
            Owner
        </option>

        <option value="2"
            <?= isset($data_edit) && $data_edit['level'] == 2 ? 'selected' : ''; ?>>
            Kasir
        </option>
    </select>

    <br><br>

    <?php if ($data_edit) { ?>

        <button type="submit" name="edit">Simpan Perubahan</button>

        <a href="data_user.php" class="batal">Batal</a>

    <?php } else { ?>

        <button type="submit" name="tambah">Tambah User</button>

    <?php } ?>

</form>

<h3>Daftar User</h3>

<table>

<tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Username</th>
    <th>Level</th>
    <th>Aksi</th>
</tr>

<?php while ($u = mysqli_fetch_assoc($query)) { ?>

<tr>
    <td><?= $u['id_user']; ?></td>

    <td><?= htmlspecialchars($u['nama']); ?></td>

    <td><?= htmlspecialchars($u['username']); ?></td>

    <td>
        <?= $u['level'] == 1 ? 'Owner' : 'Kasir'; ?>
    </td>

    <td>
        <a class="edit"
           href="data_user.php?edit=<?= $u['id_user']; ?>">
           Edit
        </a>

        |

        <a class="hapus"
           href="data_user.php?hapus=<?= $u['id_user']; ?>"
           onclick="return confirm('Yakin ingin menghapus user ini?')">
           Hapus
        </a>
    </td>
</tr>

<?php } ?>

</table>

</body>
</html>
