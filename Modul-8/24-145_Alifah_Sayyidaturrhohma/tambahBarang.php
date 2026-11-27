<?php
require_once "middleware.php";
cekOwner();

require_once "koneksi.php";

$error = "";
$suppliers = [];

$query_supplier = mysqli_query($conn, "SELECT id, nama FROM supplier ORDER BY nama ASC");
if ($query_supplier) {
    while ($row = mysqli_fetch_assoc($query_supplier)) {
        $suppliers[] = $row;
    }
} else {
    $error = "Gagal memuat data supplier dari database. Silakan muat ulang halaman.";
}

if (isset($_POST['simpan'])) {
    $kode_barang = trim($_POST['kode_barang'] ?? '');
    $nama_barang = trim($_POST['nama_barang'] ?? '');
    $harga       = trim($_POST['harga'] ?? '');
    $stok        = trim($_POST['stok'] ?? '');
    $supplier_id = trim($_POST['supplier_id'] ?? '');

    if (empty($suppliers)) {
        $error = "Tidak dapat menyimpan barang karena belum ada data supplier yang terdaftar!";
    }

    elseif ($kode_barang === "" || $nama_barang === "" || $harga === "" || $stok === "" || $supplier_id === "") {
        $error = "Semua kolom wajib diisi!";
    }

    elseif (strlen($kode_barang) > 10) {
        $error = "Kode barang maksimal 10 karakter!";
    } elseif (strlen($nama_barang) > 100) {
        $error = "Nama barang maksimal 100 karakter!";
    } else {

        $val_harga = filter_var($harga, FILTER_VALIDATE_INT, ["options" => ["min_range" => 0]]);

        $val_stok = filter_var($stok, FILTER_VALIDATE_INT, ["options" => ["min_range" => 0]]);

        $val_supplier_id = filter_var($supplier_id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);

        if ($val_harga === false) {
            $error = "Harga harus berupa bilangan bulat dan tidak boleh bernilai negatif!";
        } elseif ($val_stok === false) {
            $error = "Stok harus berupa bilangan bulat dan tidak boleh bernilai negatif!";
        } elseif ($val_supplier_id === false) {
            $error = "Pilihan supplier tidak valid!";
        } else {

            $stmt_cek = mysqli_prepare($conn, "SELECT id FROM barang WHERE kode_barang = ?");
            if ($stmt_cek) {
                mysqli_stmt_bind_param($stmt_cek, "s", $kode_barang);
                mysqli_stmt_execute($stmt_cek);
                mysqli_stmt_store_result($stmt_cek);

                if (mysqli_stmt_num_rows($stmt_cek) > 0) {
                    $error = "Kode barang '{$kode_barang}' sudah digunakan! Silakan gunakan kode lain.";
                    mysqli_stmt_close($stmt_cek);
                } else {
                    mysqli_stmt_close($stmt_cek);

                    $stmt_sup = mysqli_prepare($conn, "SELECT id FROM supplier WHERE id = ?");
                    if ($stmt_sup) {
                        mysqli_stmt_bind_param($stmt_sup, "i", $val_supplier_id);
                        mysqli_stmt_execute($stmt_sup);
                        mysqli_stmt_store_result($stmt_sup);

                        if (mysqli_stmt_num_rows($stmt_sup) === 0) {
                            $error = "Supplier yang dipilih tidak ditemukan pada database!";
                            mysqli_stmt_close($stmt_sup);
                        } else {
                            mysqli_stmt_close($stmt_sup);

                            $stmt_insert = mysqli_prepare($conn, "INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES (?, ?, ?, ?, ?)");
                            if ($stmt_insert) {
                                mysqli_stmt_bind_param($stmt_insert, "ssiii", $kode_barang, $nama_barang, $val_harga, $val_stok, $val_supplier_id);

                                if (mysqli_stmt_execute($stmt_insert)) {
                                    mysqli_stmt_close($stmt_insert);
                                    echo "<script>
                                        alert('Data barang baru berhasil ditambahkan!');
                                        window.location.href = 'barang.php';
                                    </script>";
                                    exit;
                                } else {
                                    $error = "Terjadi kesalahan pada sistem saat menyimpan data barang. Silakan coba lagi.";
                                    mysqli_stmt_close($stmt_insert);
                                }
                            } else {
                                $error = "Terjadi gangguan pada sistem database saat memproses data!";
                            }
                        }
                    } else {
                        $error = "Terjadi gangguan saat memverifikasi data supplier!";
                    }
                }
            } else {
                $error = "Terjadi gangguan saat memeriksa kode barang!";
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
    <title>Tambah Data Barang - Sistem Penjualan</title>
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
        .form-group input, .form-group select {
            width: 100%;
            padding: 9px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
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
        .btn-submit:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
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
        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            border: 1px solid #ffeeba;
            font-size: 13px;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Tambah Data Barang Baru</h2>
        <a href="barang.php">&laquo; Kembali ke Data Barang</a>
        <br><br>

        <?php if (!empty($error)): ?>
            <div class="alert-error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (empty($suppliers)): ?>
            <div class="alert-warning">
                <strong>Peringatan:</strong> Belum ada data supplier yang tersedia di sistem. Anda harus mengisi data supplier terlebih dahulu sebelum dapat menambahkan barang.
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="kode_barang">Kode Barang</label>
                <input type="text" id="kode_barang" name="kode_barang" maxlength="10" value="<?= htmlspecialchars($_POST['kode_barang'] ?? ''); ?>" placeholder="Contoh: BRG006" required>
            </div>

            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" id="nama_barang" name="nama_barang" maxlength="100" value="<?= htmlspecialchars($_POST['nama_barang'] ?? ''); ?>" placeholder="Masukkan nama barang" required>
            </div>

            <div class="form-group">
                <label for="harga">Harga (Rp)</label>
                <input type="number" id="harga" name="harga" min="0" step="1" value="<?= htmlspecialchars($_POST['harga'] ?? ''); ?>" placeholder="Contoh: 150000" required>
            </div>

            <div class="form-group">
                <label for="stok">Stok Awal</label>
                <input type="number" id="stok" name="stok" min="0" step="1" value="<?= htmlspecialchars($_POST['stok'] ?? ''); ?>" placeholder="Contoh: 20" required>
            </div>

            <div class="form-group">
                <label for="supplier_id">Supplier</label>
                <select id="supplier_id" name="supplier_id" required <?= empty($suppliers) ? 'disabled' : ''; ?>>
                    <option value="">-- Pilih Supplier --</option>
                    <?php foreach ($suppliers as $sup): ?>
                        <option value="<?= $sup['id']; ?>" <?= (isset($_POST['supplier_id']) && $_POST['supplier_id'] == $sup['id']) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($sup['nama']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" name="simpan" class="btn-submit" <?= empty($suppliers) ? 'disabled' : ''; ?>>Simpan Barang</button>
            <a href="barang.php" class="btn-batal">Batal</a>
        </form>
    </div>

</body>
</html>

