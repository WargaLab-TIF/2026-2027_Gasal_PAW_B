
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

if (isset($_POST['simpan'])) {
    $nama = trim($_POST['nama']);
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $telp = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

    // Membuat ID pelanggan otomatis
    $hasil = mysqli_query($conn, "SELECT MAX(CAST(id AS UNSIGNED)) AS id_terakhir FROM pelanggan");
    $data = mysqli_fetch_assoc($hasil);

    $id = (int) $data['id_terakhir'] + 1;
    $id = (string) $id;

    $query = mysqli_prepare($conn, "INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($query, "sssss", $id, $nama, $jenis_kelamin, $telp, $alamat);

    if (mysqli_stmt_execute($query)) {
        header("Location: data.php");
        exit;
    } else {
        $pesan = "Data pelanggan gagal ditambahkan.";
    }
}

include '../navbar.php';
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tambah Pelanggan</h4>
        </div>

        <div class="card-body">

            <?php if (isset($pesan)) { ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($pesan); ?>
                </div>
            <?php } ?>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Nama Pelanggan</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">No. Telepon</label>
                    <input type="text" name="telp" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" name="simpan" class="btn btn-success">
                    Simpan
                </button>

                <a href="data.php" class="btn btn-secondary">Kembali</a>

            </form>
        </div>
    </div>
</div>

</body>
</html>
