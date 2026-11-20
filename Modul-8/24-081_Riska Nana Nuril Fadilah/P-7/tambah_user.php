<?php
require 'koneksi.php';
include 'midlewire.php';

if (isset($_POST['simpan'])) {
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $password = md5($_POST['password']);
    $alamat = $_POST['alamat'];
    $hp = $_POST['hp'];
    $level = $_POST['level'];

    $query = "INSERT INTO user (username, password, nama, alamat, hp, level)
              VALUES ('$username', '$password', '$nama', '$alamat', '$hp', '$level')";

    if (mysqli_query($conn, $query)) {
        header("Location: user.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data User</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        h2 {
            color: #5b9aaa;
        }

        label {
            display: inline-block;
            width: 120px;
            margin-bottom: 15px;
        }

        input, select {
            padding: 8px;
            width: 200px;
        }

        button, a {
            padding: 8px 12px;
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .simpan {
            background-color: #5cb85c;
        }

        .batal {
            background-color: #c9302c;
        }
    </style>
</head>

<body>

    <h2>Tambah Data User</h2>

    <form method="POST">

        <label>Username</label>
        <input type="text" name="username" required>
        <br>

        <label>Nama</label>
        <input type="text" name="nama" required>
        <br>

        <label>Password</label>
        <input type="password" name="password" required>
        <br>

        <label>Alamat</label>
        <input type="text" name="alamat" required>
        <br>

        <label>HP</label>
        <input type="text" name="hp" required>
        <br>

        <label>Level</label>
        <select name="level" required>
            <option value="">-- Pilih Level --</option>
            <option value="1">Owner</option>
            <option value="2">Kasir</option>
        </select>
        <br><br>

        <button type="submit" name="simpan" class="simpan">
            Simpan
        </button>

        <a href="user.php" class="batal">Batal</a>

    </form>

</body>
</html>