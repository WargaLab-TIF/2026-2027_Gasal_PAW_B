<?php
require_once "middleware.php";
cekOwner();

require_once "koneksi.php";

$error = "";

$id = trim($_GET['id'] ?? '');
if ($id === "") {
    echo "<script>
        alert('ID pelanggan tidak valid!');
        window.location.href = 'pelanggan.php';
    </script>";
    exit;
}

$stmt_get = mysqli_prepare($conn, "SELECT id, nama, jenis_kelamin, telp, alamat FROM pelanggan WHERE id = ?");
mysqli_stmt_bind_param($stmt_get, "s", $id);
mysqli_stmt_execute($stmt_get);
$res_get = mysqli_stmt_get_result($stmt_get);
$pelanggan = mysqli_fetch_assoc($res_get);
mysqli_stmt_close($stmt_get);

if (!$pelanggan) {
    echo "<script>
        alert('Data pelanggan tidak ditemukan!');
        window.location.href = 'pelanggan.php';
    </script>";
    exit;
}

$input_nama          = $pelanggan['nama'];
$input_jenis_kelamin = $pelanggan['jenis_kelamin'];
$input_telp          = $pelanggan['telp'];
$input_alamat        = $pelanggan['alamat'];

if (isset($_POST['update'])) {
    $nama          = trim($_POST['nama'] ?? '');
    $jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');
    $telp          = trim($_POST['telp'] ?? '');
    $alamat        = trim($_POST['alamat'] ?? '');

    $input_nama          = $nama;
    $input_jenis_kelamin = $jenis_kelamin;
    $input_telp          = $telp;
    $input_alamat        = $alamat;

    if ($nama === "" || $jenis_kelamin === "" || $telp === "" || $alamat === "") {
        $error = "Semua kolom wajib diisi!";
    } elseif (strlen($nama) > 100) {
        $error = "Nama pelanggan maksimal 100 karakter!";
    } elseif (strlen($telp) > 12) {
        $error = "Nomor telepon maksimal 12 karakter!";
    } elseif ($jenis_kelamin !== 'L' && $jenis_kelamin !== 'P') {
        $error = "Pilihan jenis kelamin tidak valid!";
    } else {
        $stmt_up = mysqli_prepare($conn, "UPDATE pelanggan SET nama = ?, jenis_kelamin = ?, telp = ?, alamat = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt_up, "sssss", $nama, $jenis_kelamin, $telp, $alamat, $id);

        if (mysqli_stmt_execute($stmt_up)) {
            mysqli_stmt_close($stmt_up);
            echo "<script>
                alert('Data pelanggan berhasil diperbarui!');
                window.location.href = 'pelanggan.php';
            </script>";
            exit;
        } else {
            $error = "Terjadi kesalahan pada sistem saat memperbarui data pelanggan.";
            mysqli_stmt_close($stmt_up);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pelanggan - Sistem Penjualan</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .form-container {
            max-width: 500px;
            margin: 25px auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 9px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }
        .btn-submit {
            background-color: #0d6efd;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }
        .btn-submit:hover {
            background-color: #0b5ed7;
        }
        .btn-batal {
            color: #6c757d;
            text-decoration: none;
            margin-left: 12px;
            font-size: 14px;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            border: 1px solid #f5c6cb;
            font-size: 13px;
        }
        .info-id {
            background-color: #e9ecef;
            padding: 8px 12px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 13px;
            color: #495057;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Edit Data Pelanggan</h2>
        <a href="pelanggan.php">&laquo; Kembali ke Data Pelanggan</a>
        <br><br>

        <div class="info-id">
            Mengedit Pelanggan ID: <strong><?= htmlspecialchars($id); ?></strong>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert-error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="nama">Nama Pelanggan</label>
                <input type="text" id="nama" name="nama" maxlength="100" value="<?= htmlspecialchars($input_nama); ?>" placeholder="Masukkan nama pelanggan" required>
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="L" <?= ($input_jenis_kelamin === 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="P" <?= ($input_jenis_kelamin === 'P') ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="telp">Telepon</label>
                <input type="text" id="telp" name="telp" maxlength="12" value="<?= htmlspecialchars($input_telp); ?>" placeholder="Contoh: 081234567890" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" placeholder="Masukkan alamat pelanggan" required><?= htmlspecialchars($input_alamat); ?></textarea>
            </div>

            <button type="submit" name="update" class="btn-submit">Simpan Perubahan</button>
            <a href="pelanggan.php" class="btn-batal">Batal</a>
        </form>
    </div>

</body>
</html>

