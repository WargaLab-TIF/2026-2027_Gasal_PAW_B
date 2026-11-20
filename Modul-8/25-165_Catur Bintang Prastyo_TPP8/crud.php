<?php
include 'cek_login.php';
include 'koneksi.php';

if ($_SESSION['level'] != 1) {
    die("Akses ditolak. Halaman ini hanya untuk Owner (level 1).");
}

$config = [
    'barang' => ['judul' => 'Data Barang', 'pk' => 'id_barang', 'kolom' => [
        'nama_barang' => 'Nama Barang', 'stok' => 'Stok', 'harga' => 'Harga']],
    'supplier' => ['judul' => 'Data Supplier', 'pk' => 'id_supplier', 'kolom' => [
        'nama_supplier' => 'Nama Supplier', 'telp' => 'Telp', 'alamat' => 'Alamat']],
    'pelanggan' => ['judul' => 'Data Pelanggan', 'pk' => 'id_pelanggan', 'kolom' => [
        'nama_pelanggan' => 'Nama Pelanggan', 'telp' => 'Telp', 'alamat' => 'Alamat']],
    'user' => ['judul' => 'Data User', 'pk' => 'id_user', 'kolom' => [
        'nama' => 'Nama', 'username' => 'Username', 'password' => 'Password', 'level' => 'Level']],
];

$m     = $_GET['m'] ?? 'barang';
if (!isset($config[$m])) { die("Tabel tidak dikenal."); }
$pk    = $config[$m]['pk'];
$kolom = $config[$m]['kolom'];
$aksi  = $_GET['aksi'] ?? 'list';
$id    = $_GET['id'] ?? '';

if ($aksi == 'hapus' && $id !== '') {
    if ($m == 'user' && $id == $_SESSION['id_user']) {
        die("Tidak bisa menghapus akun yang sedang login.");
    }
    $stmt = mysqli_prepare($connect, "DELETE FROM $m WHERE $pk = ?");
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    header("Location: crud.php?m=$m");
    exit();
}

// ===== SIMPAN (TAMBAH / EDIT) =====
if (isset($_POST['simpan'])) {
    $data = [];
    foreach ($kolom as $k => $label) {
        $v = trim($_POST[$k] ?? '');
        if ($k == 'password') {
            if ($v === '' && $id !== '') { continue; } // edit tanpa ganti password
            $v = md5($v);
        }
        $data[$k] = $v;
    }

    $values = array_values($data);
    $types  = str_repeat('s', count($values));

    if ($id === '') {
        $names = implode(', ', array_keys($data));
        $marks = implode(', ', array_fill(0, count($data), '?'));
        $stmt  = mysqli_prepare($connect, "INSERT INTO $m ($names) VALUES ($marks)");
        mysqli_stmt_bind_param($stmt, $types, ...$values);
    } else {
        $set   = implode(', ', array_map(fn($k) => "$k = ?", array_keys($data)));
        $stmt  = mysqli_prepare($connect, "UPDATE $m SET $set WHERE $pk = ?");
        $values[] = $id;
        mysqli_stmt_bind_param($stmt, $types . 's', ...$values);
    }
    mysqli_stmt_execute($stmt);
    header("Location: crud.php?m=$m");
    exit();
}

include 'navbar.php';
echo "<h2>{$config[$m]['judul']}</h2>";

if ($aksi == 'list') {
    echo "<a href='crud.php?m=$m&aksi=tambah'>+ Tambah Data</a><br><br>";
    $result = mysqli_query($connect, "SELECT * FROM $m");

    echo "<table border='1' cellpadding='6'><tr><th>No</th>";
    foreach ($kolom as $k => $label) {
        if ($k != 'password') { echo "<th>$label</th>"; }
    }
    echo "<th>Aksi</th></tr>";

    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>$no</td>";
        foreach ($kolom as $k => $label) {
            if ($k == 'password') { continue; }
            if ($k == 'level') {
                $tampil = $row[$k] == 1 ? 'Owner' : 'Kasir';
            } else {
                $tampil = htmlspecialchars($row[$k]);
            }
            echo "<td>$tampil</td>";
        }
        $idRow = $row[$pk];
        echo "<td>
                <a href='crud.php?m=$m&aksi=edit&id=$idRow'>Edit</a> |
                <a href='crud.php?m=$m&aksi=hapus&id=$idRow'
                   onclick=\"return confirm('Yakin hapus data ini?')\">Hapus</a>
              </td></tr>";
        $no++;
    }
    echo "</table>";

} else {
    $data = [];
    if ($aksi == 'edit' && $id !== '') {
        $stmt = mysqli_prepare($connect, "SELECT * FROM $m WHERE $pk = ?");
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    }

    echo "<form method='post' action='crud.php?m=$m&aksi=$aksi&id=$id'>";
    foreach ($kolom as $k => $label) {
        echo "$label<br>";
        if ($k == 'level') {
            $lv   = $data['level'] ?? '';
            $sel1 = $lv == 1 ? 'selected' : '';
            $sel2 = $lv == 2 ? 'selected' : '';
            echo "<select name='level'>
                    <option value='1' $sel1>1 - Owner</option>
                    <option value='2' $sel2>2 - Kasir</option>
                  </select><br><br>";
        } elseif ($k == 'password') {
            $req = $id === '' ? 'required' : '';
            $ket = $id === '' ? '' : '(kosongkan jika tidak diganti)';
            echo "<input type='password' name='password' $req> $ket<br><br>";
        } else {
            $val = htmlspecialchars($data[$k] ?? '');
            echo "<input type='text' name='$k' value='$val' required><br><br>";
        }
    }
    echo "<input type='submit' name='simpan' value='Simpan'>
          <a href='crud.php?m=$m'>Batal</a></form>";
}
?>
