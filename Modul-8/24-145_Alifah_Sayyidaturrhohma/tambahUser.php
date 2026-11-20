<?php
require_once "middleware.php";
cekOwner();

require_once "koneksi.php";

$error = "";

if (isset($_POST['submit'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $nama     = trim($_POST['nama'] ?? '');
    $level    = filter_var($_POST['level'] ?? null, FILTER_VALIDATE_INT);
    $hp       = trim($_POST['hp'] ?? '');
    $alamat   = trim($_POST['alamat'] ?? '');

    if ($username === "" || $password === "" || $nama === "" || !$level || ($level !== 1 && $level !== 2)) {
        $error = "Semua kolom bertanda * wajib diisi dengan benar!";
    } else {

        $stmt_cek = mysqli_prepare($conn, "SELECT id_user FROM user WHERE username = ?");
        mysqli_stmt_bind_param($stmt_cek, "s", $username);
        mysqli_stmt_execute($stmt_cek);
        mysqli_stmt_store_result($stmt_cek);

        if (mysqli_stmt_num_rows($stmt_cek) > 0) {
            $error = "Username '$username' sudah digunakan! Silakan gunakan username lain.";
            mysqli_stmt_close($stmt_cek);
        } else {
            mysqli_stmt_close($stmt_cek);

            $res_id = mysqli_query($conn, "SELECT MAX(id_user) AS max_id FROM user");
            $row_id = mysqli_fetch_assoc($res_id);
            $next_id = ($row_id && $row_id['max_id'] !== null) ? ((int)$row_id['max_id'] + 1) : 1;

            $stmt_ins = mysqli_prepare($conn, "INSERT INTO user (id_user, username, password, nama, alamat, hp, level) VALUES (?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt_ins, "isssssi", $next_id, $username, $password, $nama, $alamat, $hp, $level);

            if (mysqli_stmt_execute($stmt_ins)) {
                mysqli_stmt_close($stmt_ins);
                echo "<script>
                    alert('Data user baru berhasil ditambahkan!');
                    window.location.href = 'user.php';
                </script>";
                exit;
            } else {
                $error = "Gagal menyimpan data user: " . mysqli_error($conn);
                mysqli_stmt_close($stmt_ins);
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
    <title>Tambah User Baru - Sistem Penjualan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Tambah User Baru</h2>
    <a href="user.php">&laquo; Kembali ke Data User</a>
    <br><br>

    <?php if ($error !== ""): ?>
        <p style="color: red; font-weight: bold;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <table>
            <tr>
                <td><label for="username">Username *</label></td>
                <td><input type="text" id="username" name="username" maxlength="30" required value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"></td>
            </tr>
            <tr>
                <td><label for="password">Password *</label></td>
                <td><input type="password" id="password" name="password" maxlength="35" required></td>
            </tr>
            <tr>
                <td><label for="nama">Nama Lengkap *</label></td>
                <td><input type="text" id="nama" name="nama" maxlength="50" required value="<?php echo htmlspecialchars($_POST['nama'] ?? ''); ?>"></td>
            </tr>
            <tr>
                <td><label for="level">Level *</label></td>
                <td>
                    <select id="level" name="level" required>
                        <option value="">-- Pilih Level --</option>
                        <option value="1" <?php echo (isset($_POST['level']) && (int)$_POST['level'] === 1) ? 'selected' : ''; ?>>1 - Owner</option>
                        <option value="2" <?php echo (isset($_POST['level']) && (int)$_POST['level'] === 2) ? 'selected' : ''; ?>>2 - Kasir</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="hp">No. Handphone</label></td>
                <td><input type="text" id="hp" name="hp" maxlength="20" value="<?php echo htmlspecialchars($_POST['hp'] ?? ''); ?>"></td>
            </tr>
            <tr>
                <td><label for="alamat">Alamat</label></td>
                <td><textarea id="alamat" name="alamat" rows="3" cols="30"><?php echo htmlspecialchars($_POST['alamat'] ?? ''); ?></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit" name="submit">Simpan User</button></td>
            </tr>
        </table>
    </form>

</body>
</html>

