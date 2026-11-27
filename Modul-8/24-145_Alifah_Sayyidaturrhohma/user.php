<?php
require_once "middleware.php";
cekOwner();

require_once "koneksi.php";

$query = mysqli_query($conn, "SELECT * FROM user ORDER BY id_user ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Master User - Sistem Penjualan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Data Master User</h2>
    <div>
        <a href="index.php">&laquo; Kembali ke Dashboard</a>
    </div>
    <br>
    <div>
        <a href="tambahUser.php"><strong>+ Tambah User Baru</strong></a>
    </div>
    <br>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>ID User</th>
            <th>Username</th>
            <th>Nama Lengkap</th>
            <th>Level</th>
            <th>No. HP</th>
            <th>Alamat</th>
            <th>Tindakan</th>
        </tr>

        <?php
        $no = 1;
        while ($data = mysqli_fetch_assoc($query)) {
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo (int)$data['id_user']; ?></td>
            <td><?php echo htmlspecialchars($data['username']); ?></td>
            <td><?php echo htmlspecialchars($data['nama']); ?></td>
            <td>
                <?php
                if ((int)$data['level'] === 1) {
                    echo "<strong>1 (Owner)</strong>";
                } else {
                    echo "2 (Kasir)";
                }
                ?>
            </td>
            <td><?php echo htmlspecialchars($data['hp']); ?></td>
            <td><?php echo htmlspecialchars($data['alamat']); ?></td>
            <td>
                <a href="editUser.php?id=<?php echo (int)$data['id_user']; ?>">Edit</a> |
                <?php if ((int)$data['id_user'] === (int)$_SESSION['id_user']): ?>
                    <span style="color: gray;" title="Akun yang sedang aktif tidak bisa dihapus">Hapus</span>
                <?php else: ?>
                    <a href="hapusUser.php?id=<?php echo (int)$data['id_user']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus user <?php echo htmlspecialchars($data['username']); ?>?');">Hapus</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php } ?>
    </table>

</body>
</html>

