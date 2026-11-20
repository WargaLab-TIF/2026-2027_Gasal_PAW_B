<?php
include "validasi.php";
include "koneksi.php";

wajib_owner();

$pesan = "";

// PROSES TAMBAH SUPPLIER
if (isset($_POST['tambah'])) {

    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_supplier']);
    $telp = mysqli_real_escape_string($koneksi, $_POST['telp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    $query = mysqli_query($koneksi, "
        INSERT INTO supplier (nama_supplier, telp, alamat)
        VALUES ('$nama', '$telp', '$alamat')
    ");

    if ($query) {
        header("Location: data_supplier.php?status=tambah");
        exit;
    } else {
        $pesan = "Gagal menambahkan supplier: " . mysqli_error($koneksi);
    }
}

// PROSES EDIT SUPPLIER
if (isset($_POST['edit'])) {

    $id = (int) $_POST['id_supplier'];
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_supplier']);
    $telp = mysqli_real_escape_string($koneksi, $_POST['telp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    $query = mysqli_query($koneksi, "
        UPDATE supplier
        SET nama_supplier = '$nama',
            telp = '$telp',
            alamat = '$alamat'
        WHERE id_supplier = $id
    ");

    if ($query) {
        header("Location: data_supplier.php?status=edit");
        exit;
    } else {
        $pesan = "Gagal mengubah supplier: " . mysqli_error($koneksi);
    }
}

// PROSES HAPUS SUPPLIER
if (isset($_GET['hapus'])) {

    $id = (int) $_GET['hapus'];

    $query = mysqli_query($koneksi, "
        DELETE FROM supplier
        WHERE id_supplier = $id
    ");

    if ($query) {
        header("Location: data_supplier.php?status=hapus");
        exit;
    } else {
        $pesan = "Supplier tidak dapat dihapus. Pastikan supplier tidak sedang digunakan oleh data barang.";
    }
}

// MENGAMBIL DATA UNTUK EDIT
$data_edit = null;

if (isset($_GET['edit'])) {

    $id = (int) $_GET['edit'];

    $result_edit = mysqli_query($koneksi, "
        SELECT * FROM supplier
        WHERE id_supplier = $id
    ");

    $data_edit = mysqli_fetch_assoc($result_edit);
}

// MENGAMBIL SELURUH DATA SUPPLIER
$supplier = mysqli_query($koneksi, "
    SELECT * FROM supplier
    ORDER BY id_supplier ASC
");

if (!$supplier) {
    die("Gagal mengambil data supplier: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Supplier</title>

    <link rel="stylesheet" href="style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 25px;
            color: #555;
        }

        h2 {
            color: #39758d;
            font-size: 24px;
            font-weight: normal;
            border-bottom: 1px solid #ddd;
            padding-bottom: 12px;
        }

        .form {
            width: 450px;
            margin: 25px 0;
        }

        label {
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 9px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background: #75ad43;
            color: white;
            border: none;
            padding: 9px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        .batal {
            background: #c82333;
            color: white;
            padding: 9px 15px;
            text-decoration: none;
            border-radius: 4px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #39758d;
            color: white;
        }

        .edit {
            color: #ed6b16;
            text-decoration: none;
        }

        .hapus {
            color: #c82333;
            text-decoration: none;
        }

        .pesan {
            color: green;
            margin: 15px 0;
        }
    </style>
</head>

<body>

<h2>Data Supplier</h2>

<a href="index.php">Home</a>

<?php
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'tambah') {
        echo "<p class='pesan'>Supplier berhasil ditambahkan.</p>";
    } elseif ($_GET['status'] == 'edit') {
        echo "<p class='pesan'>Supplier berhasil diubah.</p>";
    } elseif ($_GET['status'] == 'hapus') {
        echo "<p class='pesan'>Supplier berhasil dihapus.</p>";
    }
}

if ($pesan != "") {
    echo "<p style='color:red;'>" . htmlspecialchars($pesan) . "</p>";
}
?>

<h3>
    <?= $data_edit ? "Edit Supplier" : "Tambah Supplier"; ?>
</h3>

<form method="POST" class="form">

    <?php if ($data_edit) { ?>
        <input type="hidden" name="id_supplier"
               value="<?= $data_edit['id_supplier']; ?>">
    <?php } ?>

    <label>Nama Supplier</label><br><br>
    <input type="text" name="nama_supplier"
           value="<?= htmlspecialchars($data_edit['nama_supplier'] ?? ''); ?>"
           required>
    <br><br>

    <label>Telepon</label><br><br>
    <input type="text" name="telp"
           value="<?= htmlspecialchars($data_edit['telp'] ?? ''); ?>"
           required>
    <br><br>

    <label>Alamat</label><br><br>
    <textarea name="alamat" rows="3" required><?= htmlspecialchars($data_edit['alamat'] ?? ''); ?></textarea>
    <br><br>

    <?php if ($data_edit) { ?>

        <button type="submit" name="edit">Simpan Perubahan</button>

        <a href="data_supplier.php" class="batal">Batal</a>

    <?php } else { ?>

        <button type="submit" name="tambah">Tambah Supplier</button>

    <?php } ?>

</form>

<h3>Daftar Supplier</h3>

<table>

    <tr>
        <th>ID</th>
        <th>Nama Supplier</th>
        <th>Telepon</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>

    <?php while ($s = mysqli_fetch_assoc($supplier)) { ?>

        <tr>
            <td><?= $s['id_supplier']; ?></td>

            <td><?= htmlspecialchars($s['nama_supplier']); ?></td>

            <td><?= htmlspecialchars($s['telp']); ?></td>

            <td><?= htmlspecialchars($s['alamat']); ?></td>

            <td>
                <a class="edit"
                   href="data_supplier.php?edit=<?= $s['id_supplier']; ?>">
                   Edit
                </a>

                |

                <a class="hapus"
                   href="data_supplier.php?hapus=<?= $s['id_supplier']; ?>"
                   onclick="return confirm('Yakin ingin menghapus supplier ini?')">
                   Hapus
                </a>
            </td>
        </tr>

    <?php } ?>

</table>

</body>
</html>
