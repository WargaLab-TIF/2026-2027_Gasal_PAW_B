<?php
require_once "middleware.php";
cekOwner();

require_once "koneksi.php";

$error = "";

if (isset($_POST['simpan'])) {
    $id            = trim($_POST['id'] ?? '');
    $nama          = trim($_POST['nama'] ?? '');
    $jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');
    $telp          = trim($_POST['telp'] ?? '');
    $alamat        = trim($_POST['alamat'] ?? '');

    if ($id === "" || $nama === "" || $jenis_kelamin === "" || $telp === "" || $alamat === "") {
        $error = "Semua kolom wajib diisi!";
    } elseif (strlen($id) > 20) {
        $error = "ID Pelanggan maksimal 20 karakter!";
    } elseif (strlen($nama) > 100) {
        $error = "Nama pelanggan maksimal 100 karakter!";
    } elseif (strlen($telp) > 12) {
        $error = "Nomor telepon maksimal 12 karakter!";
    } elseif ($jenis_kelamin !== 'L' && $jenis_kelamin !== 'P') {
        $error = "Pilihan jenis kelamin tidak valid!";
    } else {

        $stmt_cek = mysqli_prepare($conn, "SELECT id FROM pelanggan WHERE id = ?");
        mysqli_stmt_bind_param($stmt_cek, "s", $id);
        mysqli_stmt_execute($stmt_cek);
        mysqli_stmt_store_result($stmt_cek);

        if (mysqli_stmt_num_rows($stmt_cek) > 0) {
            $error = "ID Pelanggan '{$id}' sudah terdaftar! Gunakan ID lain.";
            mysqli_stmt_close($stmt_cek);
        } else {
            mysqli_stmt_close($stmt_cek);

            $stmt_ins = mysqli_prepare($conn, "INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt_ins, "sssss", $id, $nama, $jenis_kelamin, $telp, $alamat);

            if (mysqli_stmt_execute($stmt_ins)) {
                mysqli_stmt_close($stmt_ins);
                echo "<script>
                    alert('Data pelanggan baru berhasil ditambahkan!');
                    window.location.href = 'pelanggan.php';
                </script>";
                exit;
            } else {
                $error = "Terjadi kesalahan pada sistem saat menyimpan data pelanggan.";
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
    <title>Tambah Data Pelanggan - Sistem Penjualan</title>
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
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Tambah Data Pelanggan Baru</h2>
        <a href="pelanggan.php">&laquo; Kembali ke Data Pelanggan</a>
        <br><br>

        <?php if (!empty($error)): ?>
            <div class="alert-error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="id">ID Pelanggan</label>
                <input type="text" id="id" name="id" maxlength="20" value="<?= htmlspecialchars($_POST['id'] ?? ''); ?>" placeholder="Contoh: PLG006" required>
            </div>

            <div class="form-group">
                <label for="nama">Nama Pelanggan</label>
                <input type="text" id="nama" name="nama" maxlength="100" value="<?= htmlspecialchars($_POST['nama'] ?? ''); ?>" placeholder="Masukkan nama pelanggan" required>
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="L" <?= (($_POST['jenis_kelamin'] ?? '') === 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="P" <?= (($_POST['jenis_kelamin'] ?? '') === 'P') ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="telp">Telepon</label>
                <input type="text" id="telp" name="telp" maxlength="12" value="<?= htmlspecialchars($_POST['telp'] ?? ''); ?>" placeholder="Contoh: 081234567890" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" placeholder="Masukkan alamat pelanggan" required><?= htmlspecialchars($_POST['alamat'] ?? ''); ?></textarea>
            </div>

            <button type="submit" name="simpan" class="btn-submit">Simpan Pelanggan</button>
            <a href="pelanggan.php" class="btn-batal">Batal</a>
        </form>
    </div>

</body>
</html>

