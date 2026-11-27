<?php
require __DIR__ . "/koneksi.php";

// ===== fungsi dasar =====
function ambilSemua($sql)
{
    global $connect;
    $result = mysqli_query($connect, $sql);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function ambilSatu($sql)
{
    global $connect;
    return mysqli_fetch_assoc(mysqli_query($connect, $sql));
}

function jalankan($sql)
{
    global $connect;
    return mysqli_query($connect, $sql);
}

function esc($teks)
{
    global $connect;
    return mysqli_real_escape_string($connect, $teks);
}

// jumlah baris dari query "SELECT COUNT(*) ..."
function hitung($sql)
{
    $row = ambilSatu($sql);
    return (int)array_values($row)[0];
}

function requiredCheck($field)
{
    return trim($field) === "";
}

// ===== BARANG =====
function getBarang()
{
    return ambilSemua("SELECT b.*, s.nama AS nama_supplier FROM barang b
                       LEFT JOIN supplier s ON b.supplier_id = s.id_supplier
                       ORDER BY b.id_barang");
}

function getBarangById($id)
{
    $id = (int)$id;
    return ambilSatu("SELECT * FROM barang WHERE id_barang = $id");
}

function tambahBarang($kode, $nama, $harga, $stok, $supplier)
{
    $kode = esc($kode); $nama = esc($nama);
    $harga = (int)$harga; $stok = (int)$stok; $supplier = (int)$supplier;
    jalankan("INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id)
              VALUES ('$kode', '$nama', $harga, $stok, $supplier)");
}

function updateBarang($id, $kode, $nama, $harga, $stok, $supplier)
{
    $id = (int)$id; $kode = esc($kode); $nama = esc($nama);
    $harga = (int)$harga; $stok = (int)$stok; $supplier = (int)$supplier;
    jalankan("UPDATE barang SET kode_barang='$kode', nama_barang='$nama', harga=$harga,
              stok=$stok, supplier_id=$supplier WHERE id_barang=$id");
}

function hapusBarang($id)
{
    $id = (int)$id;
    return jalankan("DELETE FROM barang WHERE id_barang = $id");
}

function validasiBarang(&$error, $id, $kode, $nama, $harga, $stok, $supplier)
{
    if (requiredCheck($kode)) {
        $error["kode"] = "Kode barang tidak boleh kosong";
    }
    if (requiredCheck($nama)) {
        $error["nama"] = "Nama barang tidak boleh kosong";
    }
    if (requiredCheck($harga) || !is_numeric($harga)) {
        $error["harga"] = "Harga harus berupa angka";
    }
    if (requiredCheck($stok) || !is_numeric($stok)) {
        $error["stok"] = "Stok harus berupa angka";
    }
    if (requiredCheck($supplier)) {
        $error["supplier"] = "Supplier wajib dipilih";
    }
}

// ===== SUPPLIER =====
function getSupplier()
{
    return ambilSemua("SELECT * FROM supplier ORDER BY id_supplier");
}

function getSupplierById($id)
{
    $id = (int)$id;
    return ambilSatu("SELECT * FROM supplier WHERE id_supplier = $id");
}

function tambahSupplier($nama, $telp, $alamat)
{
    $nama = esc($nama); $telp = esc($telp); $alamat = esc($alamat);
    jalankan("INSERT INTO supplier (nama, telp, alamat) VALUES ('$nama', '$telp', '$alamat')");
}

function updateSupplier($id, $nama, $telp, $alamat)
{
    $id = (int)$id; $nama = esc($nama); $telp = esc($telp); $alamat = esc($alamat);
    jalankan("UPDATE supplier SET nama='$nama', telp='$telp', alamat='$alamat' WHERE id_supplier=$id");
}

function hapusSupplier($id)
{
    $id = (int)$id;
    return jalankan("DELETE FROM supplier WHERE id_supplier = $id");
}

function validasiSupplier(&$error, $nama, $telp, $alamat)
{
    if (requiredCheck($nama)) {
        $error["nama"] = "Nama supplier tidak boleh kosong";
    }
    if (requiredCheck($telp)) {
        $error["telp"] = "Telepon tidak boleh kosong";
    }
    if (requiredCheck($alamat)) {
        $error["alamat"] = "Alamat tidak boleh kosong";
    }
}

// ===== PELANGGAN =====
function getPelanggan()
{
    return ambilSemua("SELECT * FROM pelanggan ORDER BY id_pelanggan");
}

function getPelangganById($id)
{
    $id = esc($id);
    return ambilSatu("SELECT * FROM pelanggan WHERE id_pelanggan = '$id'");
}

function tambahPelanggan($id, $nama, $jk, $telp, $alamat)
{
    $id = esc($id); $nama = esc($nama); $jk = esc($jk); $telp = esc($telp); $alamat = esc($alamat);
    jalankan("INSERT INTO pelanggan (id_pelanggan, nama, jenis_kelamin, telp, alamat)
              VALUES ('$id', '$nama', '$jk', '$telp', '$alamat')");
}

function updatePelanggan($id, $nama, $jk, $telp, $alamat)
{
    $id = esc($id); $nama = esc($nama); $jk = esc($jk); $telp = esc($telp); $alamat = esc($alamat);
    jalankan("UPDATE pelanggan SET nama='$nama', jenis_kelamin='$jk', telp='$telp', alamat='$alamat'
              WHERE id_pelanggan='$id'");
}

function hapusPelanggan($id)
{
    $id = esc($id);
    return jalankan("DELETE FROM pelanggan WHERE id_pelanggan = '$id'");
}

function validasiPelanggan(&$error, $mode, $id, $nama, $jk, $telp, $alamat)
{
    if (requiredCheck($id)) {
        $error["id"] = "ID pelanggan tidak boleh kosong";
    }
    if (requiredCheck($nama)) {
        $error["nama"] = "Nama tidak boleh kosong";
    }
    if ($jk != "L" && $jk != "P") {
        $error["jk"] = "Jenis kelamin wajib dipilih";
    }
    if (requiredCheck($telp)) {
        $error["telp"] = "Telepon tidak boleh kosong";
    }
    if (requiredCheck($alamat)) {
        $error["alamat"] = "Alamat tidak boleh kosong";
    }
}

// ===== USER =====
function getUser()
{
    return ambilSemua("SELECT * FROM users ORDER BY id_user");
}

function getUserById($id)
{
    $id = (int)$id;
    return ambilSatu("SELECT * FROM users WHERE id_user = $id");
}

function tambahUser($username, $password, $nama, $alamat, $hp, $level)
{
    $username = esc($username); $password = md5($password);
    $nama = esc($nama); $alamat = esc($alamat); $hp = esc($hp); $level = (int)$level;
    jalankan("INSERT INTO users (username, password, nama, alamat, hp, level)
              VALUES ('$username', '$password', '$nama', '$alamat', '$hp', $level)");
}

// password kosong = password tidak diubah
function updateUser($id, $username, $password, $nama, $alamat, $hp, $level)
{
    $id = (int)$id; $username = esc($username);
    $nama = esc($nama); $alamat = esc($alamat); $hp = esc($hp); $level = (int)$level;
    $setPassword = "";
    if ($password != "") {
        $setPassword = ", password='" . md5($password) . "'";
    }
    jalankan("UPDATE users SET username='$username', nama='$nama', alamat='$alamat',
              hp='$hp', level=$level $setPassword WHERE id_user=$id");
}

function hapusUser($id)
{
    $id = (int)$id;
    jalankan("DELETE FROM users WHERE id_user = $id");
}

function validasiUser(&$error, $mode, $id, $username, $password, $nama, $hp, $level)
{
    if (requiredCheck($username)) {
        $error["username"] = "Username tidak boleh kosong";
    }
    // password wajib saat tambah; saat edit boleh kosong (tidak diubah)
    if ($mode == "tambah" && requiredCheck($password)) {
        $error["password"] = "Password tidak boleh kosong";
    }
    if (requiredCheck($nama)) {
        $error["nama"] = "Nama tidak boleh kosong";
    }
    if ($level != "1" && $level != "2") {
        $error["level"] = "Level wajib dipilih";
    }
}
?>
