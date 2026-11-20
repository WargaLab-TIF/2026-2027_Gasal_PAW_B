<?php
require_once "middleware.php";
cekOwner();

require_once "koneksi.php";

$error = "";
$suppliers = [];

$id = filter_var($_GET['id'] ?? '', FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]);

if ($id === false) {
    echo "<script>
        alert('ID barang tidak valid!');
        window.location.href = 'barang.php';
    </script>";
    exit;
}

$stmt_barang = mysqli_prepare($conn, "SELECT id, kode_barang, nama_barang, harga, stok, supplier_id FROM barang WHERE id = ?");
if ($stmt_barang) {
    mysqli_stmt_bind_param($stmt_barang, "i", $id);
    mysqli_stmt_execute($stmt_barang);
    $result_barang = mysqli_stmt_get_result($stmt_barang);
    $barang = mysqli_fetch_assoc($result_barang);
    mysqli_stmt_close($stmt_barang);

    if (!$barang) {
        echo "<script>
            alert('Data barang tidak ditemukan!');
            window.location.href = 'barang.php';
        </script>";
        exit;
    }
} else {
    echo "<script>
        alert('Terjadi gangguan saat mengambil data barang!');
        window.location.href = 'barang.php';
    </script>";
    exit;
}

$query_supplier = mysqli_query($conn, "SELECT id, nama FROM supplier ORDER BY nama ASC");
if ($query_supplier) {
    while ($row = mysqli_fetch_assoc($query_supplier)) {
        $suppliers[] = $row;
    }
} else {
    $error = "Gagal memuat data supplier dari database. Silakan muat ulang halaman.";
}

$input_kode_barang = $barang['kode_barang'];
$input_nama_barang = $barang['nama_barang'];
$input_harga       = $barang['harga'];
$input_stok        = $barang['stok'];
$input_supplier_id = $barang['supplier_id'];

if (isset($_POST['update'])) {
    $kode_barang = trim($_POST['kode_barang'] ?? '');
    $nama_barang = trim($_POST['nama_barang'] ?? '');
    $harga       = trim($_POST['harga'] ?? '');
    $stok        = trim($_POST['stok'] ?? '');
    $supplier_id = trim($_POST['supplier_id'] ?? '');

    $input_kode_barang = $kode_barang;
    $input_nama_barang = $nama_barang;
    $input_harga       = $harga;
    $input_stok        = $stok;
    $input_supplier_id = $supplier_id;

    if ($kode_barang === "" || $nama_barang === "" || $harga === "" || $stok === "" || $supplier_id === "") {
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

            $stmt_cek = mysqli_prepare($conn, "SELECT id FROM barang WHERE kode_barang = ? AND id != ?");
            if ($stmt_cek) {
                mysqli_stmt_bind_param($stmt_cek, "si", $kode_barang, $id);
                mysqli_stmt_execute($stmt_cek);
                mysqli_stmt_store_result($stmt_cek);

                if (mysqli_stmt_num_rows($stmt_cek) > 0) {
                    $error = "Kode barang '{$kode_barang}' sudah digunakan oleh barang lain! Silakan gunakan kode unik.";
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

                            $stmt_update = mysqli_prepare($conn, "UPDATE barang SET kode_barang = ?, nama_barang = ?, harga = ?, stok = ?, supplier_id = ? WHERE id = ?");
                            if ($stmt_update) {
                                mysqli_stmt_bind_param($stmt_update, "ssiiii", $kode_barang, $nama_barang, $val_harga, $val_stok, $val_supplier_id, $id);

                                if (mysqli_stmt_execute($stmt_update)) {
                                    mysqli_stmt_close($stmt_update);
                                    echo "<script>
                                        alert('Data barang berhasil diperbarui!');
                                        window.location.href = 'barang.php';
                                    </script>";
                                    exit;
                                } else {
                                    $error = "Terjadi kesalahan pada sistem saat memperbarui data barang. Silakan coba lagi.";
                                    mysqli_stmt_close($stmt_update);
                                }
                            } else {
                                $error = "Terjadi gangguan pada sistem database saat memperbarui data!";
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
    <title>Edit Data Barang - Sistem Penjualan</title>
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
        <h2>Edit Data Barang</h2>
        <a href="barang.php">&laquo; Kembali ke Data Barang</a>
        <br><br>

        <div class="info-id">
            Mengedit Barang ID: <strong><?= (int)$barang['id']; ?></strong>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert-error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="kode_barang">Kode Barang</label>
                <input type="text" id="kode_barang" name="kode_barang" maxlength="10" value="<?= htmlspecialchars($input_kode_barang); ?>" placeholder="Contoh: BRG001" required>
            </div>

            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" id="nama_barang" name="nama_barang" maxlength="100" value="<?= htmlspecialchars($input_nama_barang); ?>" placeholder="Masukkan nama barang" required>
            </div>

            <div class="form-group">
                <label for="harga">Harga (Rp)</label>
                <input type="number" id="harga" name="harga" min="0" step="1" value="<?= htmlspecialchars((string)$input_harga); ?>" placeholder="Contoh: 150000" required>
            </div>

            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" id="stok" name="stok" min="0" step="1" value="<?= htmlspecialchars((string)$input_stok); ?>" placeholder="Contoh: 20" required>
            </div>

            <div class="form-group">
                <label for="supplier_id">Supplier</label>
                <select id="supplier_id" name="supplier_id" required>
                    <option value="">-- Pilih Supplier --</option>
                    <?php foreach ($suppliers as $sup): ?>
                        <option value="<?= $sup['id']; ?>" <?= ((string)$input_supplier_id === (string)$sup['id']) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($sup['nama']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" name="update" class="btn-submit">Perbarui Barang</button>
            <a href="barang.php" class="btn-batal">Batal</a>
        </form>
    </div>

</body>
</html>

