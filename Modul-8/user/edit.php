
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['level'] != 1) {
    header("Location: ../index.php");
    exit;
}

require_once '../koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$query = mysqli_prepare($conn, "SELECT * FROM user WHERE id_user = ?");
mysqli_stmt_bind_param($query, "i", $id);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data user tidak ditemukan. <a href='data.php'>Kembali</a>");
}

if (isset($_POST['simpan'])) {
    $username = trim($_POST['username']);
    $nama = trim($_POST['nama']);
    $alamat = trim($_POST['alamat']);
    $hp = trim($_POST['hp']);
    $level = (int) $_POST['level'];
    $password = $_POST['password'];

    if ($password != '') {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $query = mysqli_prepare($conn, "UPDATE user SET username=?, password=?, nama=?, alamat=?, hp=?, level=? WHERE id_user=?");
        mysqli_stmt_bind_param($query, "sssssii", $username, $hash, $nama, $alamat, $hp, $level, $id);
    } else {
        $query = mysqli_prepare($conn, "UPDATE user SET username=?, nama=?, alamat=?, hp=?, level=? WHERE id_user=?");
        mysqli_stmt_bind_param($query, "ssssii", $username, $nama, $alamat, $hp, $level, $id);
    }

    if (mysqli_stmt_execute($query)) {
        header("Location: data.php");
        exit;
    } else {
        $pesan = "Data user gagal diperbarui: " . mysqli_error($conn);
    }
}

include '../navbar.php';
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit User</h4>
        </div>

        <div class="card-body">

            <?php if (isset($pesan)) { ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($pesan) ?>
                </div>
            <?php } ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control"
                        value="<?= htmlspecialchars($data['username']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control">
                    <small class="text-muted">Kosongkan jika password tidak ingin diubah.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control"
                        value="<?= htmlspecialchars($data['nama']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control"><?= htmlspecialchars($data['alamat'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">No. HP</label>
                    <input type="text" name="hp" class="form-control"
                        value="<?= htmlspecialchars($data['hp'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Level</label>
                    <select name="level" class="form-select" required>
                        <option value="1" <?= $data['level'] == 1 ? 'selected' : '' ?>>Owner</option>
                        <option value="2" <?= $data['level'] == 2 ? 'selected' : '' ?>>Kasir</option>
                    </select>
                </div>

                <button type="submit" name="simpan" class="btn btn-success">Simpan Perubahan</button>
                <a href="data.php" class="btn btn-secondary">Kembali</a>
            </form>

        </div>
    </div>
</div>

</body>
</html>
