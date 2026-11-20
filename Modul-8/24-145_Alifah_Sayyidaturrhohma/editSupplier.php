<?php
require_once "middleware.php";
cekOwner();

require_once "koneksi.php";

$error = "";

$id = filter_var($_GET['id'] ?? '', FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);

if ($id === false) {
    echo "<script>
        alert('ID supplier tidak valid!');
        window.location.href = 'supplier.php';
    </script>";
    exit;
}

$stmt_get = mysqli_prepare($conn, "SELECT id, nama, telp, alamat FROM supplier WHERE id = ?");
if ($stmt_get) {
    mysqli_stmt_bind_param($stmt_get, "i", $id);
    mysqli_stmt_execute($stmt_get);
    $result_sup = mysqli_stmt_get_result($stmt_get);
    $supplier = mysqli_fetch_assoc($result_sup);
    mysqli_stmt_close($stmt_get);

    if (!$supplier) {
        echo "<script>
            alert('Data supplier tidak ditemukan!');
            window.location.href = 'supplier.php';
        </script>";
        exit;
    }
} else {
    echo "<script>
        alert('Terjadi gangguan saat mengambil data supplier!');
        window.location.href = 'supplier.php';
    </script>";
    exit;
}

$input_nama   = $supplier['nama'];
$input_telp   = $supplier['telp'];
$input_alamat = $supplier['alamat'];

if (isset($_POST['update'])) {
    $nama   = trim($_POST['nama'] ?? '');
    $telp   = trim($_POST['telp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    $input_nama   = $nama;
    $input_telp   = $telp;
    $input_alamat = $alamat;

    if ($nama === "" || $telp === "" || $alamat === "") {
        $error = "Semua kolom wajib diisi!";
    }

    elseif (strlen($nama) > 100) {
        $error = "Nama supplier maksimal 100 karakter!";
    } elseif (strlen($telp) > 12) {
        $error = "Nomor telepon maksimal 12 karakter!";
    } else {

        $stmt_update = mysqli_prepare($conn, "UPDATE supplier SET nama = ?, telp = ?, alamat = ? WHERE id = ?");
        if ($stmt_update) {
            mysqli_stmt_bind_param($stmt_update, "sssi", $nama, $telp, $alamat, $id);

            if (mysqli_stmt_execute($stmt_update)) {
                mysqli_stmt_close($stmt_update);
                echo "<script>
                    alert('Data supplier berhasil diperbarui!');
                    window.location.href = 'supplier.php';
                </script>";
                exit;
            } else {
                $error = "Terjadi kesalahan pada sistem saat memperbarui data supplier. Silakan coba lagi.";
                mysqli_stmt_close($stmt_update);
            }
        } else {
            $error = "Terjadi gangguan pada sistem database!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Supplier - Sistem Penjualan</title>
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
        .form-group input, .form-group textarea {
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
        <h2>Edit Data Supplier</h2>
        <a href="supplier.php">&laquo; Kembali ke Data Supplier</a>
        <br><br>

        <div class="info-id">
            Mengedit Supplier ID: <strong><?= (int)$supplier['id']; ?></strong>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert-error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="nama">Nama Supplier</label>
                <input type="text" id="nama" name="nama" maxlength="100" value="<?= htmlspecialchars($input_nama); ?>" placeholder="Contoh: PT Sumber Makmur" required>
            </div>

            <div class="form-group">
                <label for="telp">Telepon</label>
                <input type="text" id="telp" name="telp" maxlength="12" value="<?= htmlspecialchars($input_telp); ?>" placeholder="Contoh: 081234567890" required>
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" placeholder="Masukkan alamat lengkap supplier" required><?= htmlspecialchars($input_alamat); ?></textarea>
            </div>

            <button type="submit" name="update" class="btn-submit">Simpan Perubahan</button>
            <a href="supplier.php" class="btn-batal">Batal</a>
        </form>
    </div>

</body>
</html>

