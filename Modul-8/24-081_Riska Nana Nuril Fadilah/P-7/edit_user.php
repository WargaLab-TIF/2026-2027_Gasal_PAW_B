<?php
require 'koneksi.php';
include 'midlewire.php';

if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];

    $query = "SELECT * FROM user WHERE id_user='$id_user'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        die("Data user tidak ditemukan!");
    }
} else {
    die("ID user tidak ditemukan!");
}

if (isset($_POST['update'])) {
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $hp = $_POST['hp'];
    $level = $_POST['level'];

    if ($_POST['password'] != '') {
        $password = md5($_POST['password']);

        $query = "UPDATE user SET
                  username='$username',
                  password='$password',
                  nama='$nama',
                  alamat='$alamat',
                  hp='$hp',
                  level='$level'
                  WHERE id_user='$id_user'";
    } else {
        $query = "UPDATE user SET
                  username='$username',
                  nama='$nama',
                  alamat='$alamat',
                  hp='$hp',
                  level='$level'
                  WHERE id_user='$id_user'";
    }

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
    <title>Edit Data User</title>
    <style>
        body {
            font-family: Arial;
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

        .update {
            background: #5cb85c;
        }

        .batal {
            background: #c9302c;
        }
    </style>
</head>
<body>

<h2>Edit Data User</h2>

<form method="POST">
    <label>Username</label>
    <input type="text" name="username"
           value="<?php echo htmlspecialchars($data['username']); ?>" required><br>

    <label>Nama</label>
    <input type="text" name="nama"
           value="<?php echo htmlspecialchars($data['nama']); ?>" required><br>

    <label>Password</label>
    <input type="password" name="password"
           placeholder="Kosongkan jika tidak diubah"><br>

    <label>Alamat</label>
    <input type="text" name="alamat"
           value="<?php echo htmlspecialchars($data['alamat']); ?>" required><br>

    <label>HP</label>
    <input type="text" name="hp"
           value="<?php echo htmlspecialchars($data['hp']); ?>" required><br>

    <label>Level</label>
    <select name="level" required>
        <option value="1" <?php if ($data['level'] == 1) echo 'selected'; ?>>Owner</option>
        <option value="2" <?php if ($data['level'] == 2) echo 'selected'; ?>>Kasir</option>
    </select><br><br>

    <button type="submit" name="update" class="update">Update</button>
    <a href="user.php" class="batal">Batal</a>
</form>

</body>
</html>