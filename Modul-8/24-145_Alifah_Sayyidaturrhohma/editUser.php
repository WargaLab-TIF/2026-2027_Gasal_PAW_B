<?php
require_once "middleware.php";
cekOwner();

require_once "koneksi.php";

$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

if (!$id) {
    echo "<script>
        alert('ID User tidak valid!');
        window.location.href = 'user.php';
    </script>";
    exit;
}

$stmt_get = mysqli_prepare($conn, "SELECT * FROM user WHERE id_user = ?");
mysqli_stmt_bind_param($stmt_get, "i", $id);
mysqli_stmt_execute($stmt_get);
$res_get = mysqli_stmt_get_result($stmt_get);
$user_data = mysqli_fetch_assoc($res_get);
mysqli_stmt_close($stmt_get);

if (!$user_data) {
    echo "<script>
        alert('Data user tidak ditemukan!');
        window.location.href = 'user.php';
    </script>";
    exit;
}

$error = "";

if (isset($_POST['submit'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $nama     = trim($_POST['nama'] ?? '');
    $level    = filter_var($_POST['level'] ?? null, FILTER_VALIDATE_INT);
    $hp       = trim($_POST['hp'] ?? '');
    $alamat   = trim($_POST['alamat'] ?? '');

    if ($username === "" || $nama === "" || !$level || ($level !== 1 && $level !== 2)) {
        $error = "Kolom bertanda * wajib diisi dengan benar!";
    } else {

        $stmt_cek = mysqli_prepare($conn, "SELECT id_user FROM user WHERE username = ? AND id_user != ?");
        mysqli_stmt_bind_param($stmt_cek, "si", $username, $id);
        mysqli_stmt_execute($stmt_cek);
        mysqli_stmt_store_result($stmt_cek);

        if (mysqli_stmt_num_rows($stmt_cek) > 0) {
            $error = "Username '$username' sudah digunakan oleh user lain!";
            mysqli_stmt_close($stmt_cek);
        } else {
            mysqli_stmt_close($stmt_cek);

            if ($password !== "") {

                $stmt_upd = mysqli_prepare($conn, "UPDATE user SET username = ?, password = ?, nama = ?, alamat = ?, hp = ?, level = ? WHERE id_user = ?");
                mysqli_stmt_bind_param($stmt_upd, "sssssii", $username, $password, $nama, $alamat, $hp, $level, $id);
            } else {

                $stmt_upd = mysqli_prepare($conn, "UPDATE user SET username = ?, nama = ?, alamat = ?, hp = ?, level = ? WHERE id_user = ?");
                mysqli_stmt_bind_param($stmt_upd, "ssssii", $username, $nama, $alamat, $hp, $level, $id);
            }

            if (mysqli_stmt_execute($stmt_upd)) {
                mysqli_stmt_close($stmt_upd);

                if ($id === (int)$_SESSION['id_user']) {
                    $_SESSION['username'] = $username;
                    $_SESSION['nama'] = $nama;
                    $_SESSION['level'] = $level;
                }

                echo "<script>
                    alert('Data user berhasil diperbarui!');
                    window.location.href = 'user.php';
                </script>";
                exit;
            } else {
                $error = "Gagal memperbarui data user: " . mysqli_error($conn);
                mysqli_stmt_close($stmt_upd);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data User - Sistem Penjualan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Edit Data User</h2>
    <a href="user.php">&laquo; Kembali ke Data User</a>
    <br><br>

    <?php if ($error !== ""): ?>
        <p style="color: red; font-weight: bold;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <table>
            <tr>
                <td>ID User</td>
                <td><strong><?php echo (int)$user_data['id_user']; ?></strong></td>
            </tr>
            <tr>
                <td><label for="username">Username *</label></td>
                <td><input type="text" id="username" name="username" maxlength="30" required value="<?php echo htmlspecialchars($_POST['username'] ?? $user_data['username']); ?>"></td>
            </tr>
            <tr>
                <td><label for="password">Password Baru</label></td>
                <td>
                    <input type="password" id="password" name="password" maxlength="35">
                    <br><small style="color: gray;">Kosongkan jika tidak ingin mengubah password lama.</small>
                </td>
            </tr>
            <tr>
                <td><label for="nama">Nama Lengkap *</label></td>
                <td><input type="text" id="nama" name="nama" maxlength="50" required value="<?php echo htmlspecialchars($_POST['nama'] ?? $user_data['nama']); ?>"></td>
            </tr>
            <tr>
                <td><label for="level">Level *</label></td>
                <td>
                    <?php
                    $curr_level = isset($_POST['level']) ? (int)$_POST['level'] : (int)$user_data['level'];
                    ?>
                    <select id="level" name="level" required>
                        <option value="1" <?php echo ($curr_level === 1) ? 'selected' : ''; ?>>1 - Owner</option>
                        <option value="2" <?php echo ($curr_level === 2) ? 'selected' : ''; ?>>2 - Kasir</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="hp">No. Handphone</label></td>
                <td><input type="text" id="hp" name="hp" maxlength="20" value="<?php echo htmlspecialchars($_POST['hp'] ?? $user_data['hp']); ?>"></td>
            </tr>
            <tr>
                <td><label for="alamat">Alamat</label></td>
                <td><textarea id="alamat" name="alamat" rows="3" cols="30"><?php echo htmlspecialchars($_POST['alamat'] ?? $user_data['alamat']); ?></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit" name="submit">Simpan Perubahan</button></td>
            </tr>
        </table>
    </form>

</body>
</html>

