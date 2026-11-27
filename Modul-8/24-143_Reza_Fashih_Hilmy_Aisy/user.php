<?php
require_once 'auth.php';
require_owner();
include "koneksi.php";
$pesan = "";
$id_edit = 0;
$data_edit = array("username" => "", "nama" => "", "alamat" => "", "hp" => "", "level" => 2);

if (isset($_POST['simpan'])) {
    $id = (int) $_POST['id_user'];
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $hp = mysqli_real_escape_string($conn, $_POST['hp']);
    $level = (int) $_POST['level'];
    $password = $_POST['password'];

    if ($id > 0) {
        if ($password != "") {
            $password = md5($password);
            $query = "UPDATE user SET username='$username', password='$password', nama='$nama', alamat='$alamat', hp='$hp', level=$level WHERE id_user=$id";
        } else {
            $query = "UPDATE user SET username='$username', nama='$nama', alamat='$alamat', hp='$hp', level=$level WHERE id_user=$id";
        }
        $pesan = mysqli_query($conn, $query) ? "Data user berhasil diubah." : "Data user gagal diubah.";
    } else {
        if ($password == "") {
            $pesan = "Password harus diisi untuk user baru.";
        } else {
            $password = md5($password);
            $cek = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
            if (mysqli_num_rows($cek) > 0) {
                $pesan = "Username sudah digunakan.";
            } else {
                $query = "INSERT INTO user (username, password, nama, alamat, hp, level) VALUES ('$username', '$password', '$nama', '$alamat', '$hp', $level)";
                $pesan = mysqli_query($conn, $query) ? "Data user berhasil ditambahkan." : "Data user gagal ditambahkan.";
            }
        }
    }
}

if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    if ($id == $_SESSION['id_user']) {
        $pesan = "User yang sedang login tidak dapat dihapus.";
    } else {
        $pesan = mysqli_query($conn, "DELETE FROM user WHERE id_user=$id") ? "Data user berhasil dihapus." : "Data user gagal dihapus.";
    }
}

if (isset($_GET['edit'])) {
    $id_edit = (int) $_GET['edit'];
    $hasil = mysqli_query($conn, "SELECT * FROM user WHERE id_user=$id_edit");
    if (mysqli_num_rows($hasil) > 0) $data_edit = mysqli_fetch_assoc($hasil);
}
$query = mysqli_query($conn, "SELECT * FROM user ORDER BY id_user");
?>
<!DOCTYPE html><html><head><title>Data User</title><style>
body{font-family:Arial;background:whitesmoke;margin:30px;color:darkslategray}h2{color:cadetblue}.app-nav{display:flex;align-items:center;flex-wrap:wrap;gap:5px;margin-bottom:20px}.app-nav a,.logout-form input{background:cadetblue;color:white;text-decoration:none;padding:9px 12px;border:0;border-radius:5px;cursor:pointer}.dropdown{position:relative}.dropdown-content{display:none;position:absolute;background:white;min-width:150px;z-index:1}.dropdown-content a{display:block}.dropdown:hover .dropdown-content{display:block}.user-info{margin:5px 10px}.logout-form{margin:0}table{width:100%;border-collapse:collapse;background:white;margin-top:15px}th{background:lightblue}th,td{border:1px solid lightgray;padding:9px}input,select{padding:8px;margin:5px}.pesan{padding:10px;background:lightyellow}
</style></head><body>
<?php app_nav(); ?><h2>Data User</h2>
<?php if ($pesan != "") echo "<p class='pesan'>$pesan</p>"; ?>
<h3><?php echo $id_edit > 0 ? "Edit User" : "Tambah User"; ?></h3>
<form method="POST"><input type="hidden" name="id_user" value="<?php echo $id_edit; ?>"><input name="username" placeholder="Username" value="<?php echo htmlspecialchars($data_edit['username']); ?>" required><input type="password" name="password" placeholder="Password (kosongkan jika tidak diubah)"><input name="nama" placeholder="Nama" value="<?php echo htmlspecialchars($data_edit['nama']); ?>" required><input name="alamat" placeholder="Alamat" value="<?php echo htmlspecialchars($data_edit['alamat']); ?>"><input name="hp" placeholder="Nomor HP" value="<?php echo htmlspecialchars($data_edit['hp']); ?>"><select name="level"><option value="1" <?php if ($data_edit['level'] == 1) echo 'selected'; ?>>Owner</option><option value="2" <?php if ($data_edit['level'] == 2) echo 'selected'; ?>>Kasir</option></select><input type="submit" name="simpan" value="Simpan"><?php if ($id_edit > 0) { ?><a href="user.php">Batal</a><?php } ?></form>
<table><tr><th>ID</th><th>Username</th><th>Nama</th><th>Alamat</th><th>HP</th><th>Level</th><th>Aksi</th></tr>
<?php while ($data = mysqli_fetch_assoc($query)) { ?><tr><td><?php echo $data['id_user']; ?></td><td><?php echo htmlspecialchars($data['username']); ?></td><td><?php echo htmlspecialchars($data['nama']); ?></td><td><?php echo htmlspecialchars($data['alamat']); ?></td><td><?php echo htmlspecialchars($data['hp']); ?></td><td><?php echo $data['level'] == 1 ? 'Owner' : 'Kasir'; ?></td><td><a href="user.php?edit=<?php echo $data['id_user']; ?>">Edit</a> <?php if ($data['id_user'] != $_SESSION['id_user']) { ?><a href="user.php?hapus=<?php echo $data['id_user']; ?>" onclick="return confirm('Hapus user ini?')">Hapus</a><?php } else { ?>Akun aktif<?php } ?></td></tr><?php } ?></table>
</body></html>
