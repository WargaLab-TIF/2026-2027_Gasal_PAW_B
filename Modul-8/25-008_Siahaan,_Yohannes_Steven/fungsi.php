<?php
function requiredCheck($field)
{
    return trim($field) === "";
}

function getAllBarang()
{
    global $connect;
    $query = "SELECT b.*, s.nama AS nama_supplier FROM barang b LEFT JOIN supplier s ON b.supplier_id = s.id";
    $result = mysqli_query($connect, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function getBarangById($id)
{
    global $connect;
    $query = "SELECT * FROM barang WHERE id = $id";
    $result = mysqli_query($connect, $query);
    return mysqli_fetch_assoc($result);
}

function tambah_barang($kode_barang, $nama_barang, $harga, $stok, $supplier_id)
{
    global $connect;
    $query = "INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES ('$kode_barang', '$nama_barang', '$harga', '$stok', '$supplier_id')";
    mysqli_query($connect, $query);
}

function update_barang($id, $kode_barang, $nama_barang, $harga, $stok, $supplier_id)
{
    global $connect;
    $query = "UPDATE barang SET kode_barang = '$kode_barang', nama_barang = '$nama_barang', harga = '$harga', stok = '$stok', supplier_id = '$supplier_id' WHERE id = $id";
    mysqli_query($connect, $query);
}

function hapus_barang($id)
{
    global $connect;
    $cek = mysqli_query($connect, "SELECT * FROM transaksi_detail WHERE barang_id = $id");
    if (mysqli_num_rows($cek) > 0) {
        return false;
    }
    mysqli_query($connect, "DELETE FROM barang WHERE id = $id");
    return true;
}

function validateKodeBarang(&$error, $kode_barang)
{
    if (requiredCheck($kode_barang)) {
        $error["kode_barang"] = "Kode barang tidak boleh kosong";
        return;
    }
    if (!preg_match("/^[a-zA-Z0-9]+$/", $kode_barang)) {
        $error["kode_barang"] = "Kode barang hanya boleh huruf dan angka";
        return;
    }
}

function validateNamaBarang(&$error, $nama_barang)
{
    if (requiredCheck($nama_barang)) {
        $error["nama_barang"] = "Nama barang tidak boleh kosong";
        return;
    }
}

function validateHarga(&$error, $harga)
{
    if (requiredCheck($harga)) {
        $error["harga"] = "Harga tidak boleh kosong";
        return;
    }
    if (!preg_match("/^[0-9]+$/", $harga) || $harga < 0) {
        $error["harga"] = "Harga harus berupa angka positif";
        return;
    }
}

function validateStok(&$error, $stok)
{
    if (requiredCheck($stok)) {
        $error["stok"] = "Stok tidak boleh kosong";
        return;
    }
    if (!preg_match("/^[0-9]+$/", $stok) || $stok < 0) {
        $error["stok"] = "Stok harus berupa angka positif";
        return;
    }
}

function validateSupplierId(&$error, $supplier_id)
{
    if (requiredCheck($supplier_id)) {
        $error["supplier_id"] = "Supplier wajib dipilih";
        return;
    }
    if (!is_numeric($supplier_id)) {
        $error["supplier_id"] = "Supplier tidak valid";
        return;
    }
}

function getAllSupplier()
{
    global $connect;
    $query = "SELECT * FROM supplier";
    $result = mysqli_query($connect, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function getSupplierById($id)
{
    global $connect;
    $query = "SELECT * FROM supplier WHERE id = $id";
    $result = mysqli_query($connect, $query);
    return mysqli_fetch_assoc($result);
}

function tambah_supplier($nama, $telp, $alamat)
{
    global $connect;
    $query = "INSERT INTO supplier (nama, telp, alamat) VALUES ('$nama', '$telp', '$alamat')";
    mysqli_query($connect, $query);
}

function update_supplier($id, $nama, $telp, $alamat)
{
    global $connect;
    $query = "UPDATE supplier SET nama = '$nama', telp = '$telp', alamat = '$alamat' WHERE id = $id";
    mysqli_query($connect, $query);
}

function hapus_supplier($id)
{
    global $connect;
    $cek = mysqli_query($connect, "SELECT * FROM barang WHERE supplier_id = $id");
    if (mysqli_num_rows($cek) > 0) {
        return false;
    }
    mysqli_query($connect, "DELETE FROM supplier WHERE id = $id");
    return true;
}

function validateNama(&$error, $nama)
{
    if (requiredCheck($nama)) {
        $error["nama"] = "Nama tidak boleh kosong";
        return;
    }
}

function validateTelp(&$error, $telp)
{
    if (requiredCheck($telp)) {
        $error["telp"] = "Telepon tidak boleh kosong";
        return;
    }
    if (!preg_match("/^[0-9]+$/", $telp)) {
        $error["telp"] = "Telepon hanya boleh berisi angka";
        return;
    }
}

function validateAlamat(&$error, $alamat)
{
    if (requiredCheck($alamat)) {
        $error["alamat"] = "Alamat tidak boleh kosong";
        return;
    }
}

function getAllPelanggan()
{
    global $connect;
    $query = "SELECT * FROM pelanggan";
    $result = mysqli_query($connect, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function getPelangganById($id)
{
    global $connect;
    $query = "SELECT * FROM pelanggan WHERE id = '$id'";
    $result = mysqli_query($connect, $query);
    return mysqli_fetch_assoc($result);
}

function tambah_pelanggan($id, $nama, $jenis_kelamin, $telp, $alamat)
{
    global $connect;
    $query = "INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES ('$id', '$nama', '$jenis_kelamin', '$telp', '$alamat')";
    mysqli_query($connect, $query);
}

function update_pelanggan($id, $nama, $jenis_kelamin, $telp, $alamat)
{
    global $connect;
    $query = "UPDATE pelanggan SET nama = '$nama', jenis_kelamin = '$jenis_kelamin', telp = '$telp', alamat = '$alamat' WHERE id = '$id'";
    mysqli_query($connect, $query);
}

function hapus_pelanggan($id)
{
    global $connect;
    $cek = mysqli_query($connect, "SELECT * FROM transaksi WHERE pelanggan_id = '$id'");
    if (mysqli_num_rows($cek) > 0) {
        return false;
    }
    mysqli_query($connect, "DELETE FROM pelanggan WHERE id = '$id'");
    return true;
}

function validateIdPelanggan(&$error, $id)
{
    if (requiredCheck($id)) {
        $error["id"] = "ID Pelanggan tidak boleh kosong";
        return;
    }
    if (!preg_match("/^[a-zA-Z0-9]+$/", $id)) {
        $error["id"] = "ID Pelanggan hanya boleh huruf dan angka";
        return;
    }
}

function validateJenisKelamin(&$error, $jenis_kelamin)
{
    if ($jenis_kelamin != "L" && $jenis_kelamin != "P") {
        $error["jenis_kelamin"] = "Jenis kelamin wajib dipilih";
        return;
    }
}

function getAllUser()
{
    global $connect;
    $query = "SELECT * FROM users";
    $result = mysqli_query($connect, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function getUserById($id)
{
    global $connect;
    $query = "SELECT * FROM users WHERE id_user = $id";
    $result = mysqli_query($connect, $query);
    return mysqli_fetch_assoc($result);
}

function cekUsernameAda($username)
{
    global $connect;
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($connect, $query);
    return mysqli_num_rows($result) > 0;
}

function tambah_user($username, $password, $nama, $alamat, $hp, $level)
{
    global $connect;
    $pass_hash = md5($password);
    $query = "INSERT INTO users (username, password, nama, alamat, hp, level) VALUES ('$username', '$pass_hash', '$nama', '$alamat', '$hp', '$level')";
    mysqli_query($connect, $query);
}

function update_user($id, $username, $password, $nama, $alamat, $hp, $level)
{
    global $connect;
    if (trim($password) !== "") {
        $pass_hash = md5($password);
        $query = "UPDATE users SET username = '$username', password = '$pass_hash', nama = '$nama', alamat = '$alamat', hp = '$hp', level = '$level' WHERE id_user = $id";
    } else {
        $query = "UPDATE users SET username = '$username', nama = '$nama', alamat = '$alamat', hp = '$hp', level = '$level' WHERE id_user = $id";
    }
    mysqli_query($connect, $query);
}

function hapus_user($id)
{
    global $connect;
    mysqli_query($connect, "DELETE FROM users WHERE id_user = $id");
}

function validateUsername(&$error, $username)
{
    if (requiredCheck($username)) {
        $error["username"] = "Username tidak boleh kosong";
        return;
    }
    if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
        $error["username"] = "Username hanya boleh huruf, angka, dan underscore";
        return;
    }
}

function validatePasswordUser(&$error, $password, $wajib = true)
{
    if ($wajib && requiredCheck($password)) {
        $error["password"] = "Password tidak boleh kosong";
        return;
    }
}

function validateHp(&$error, $hp)
{
    if (requiredCheck($hp)) {
        $error["hp"] = "Nomor HP tidak boleh kosong";
        return;
    }
    if (!preg_match("/^[0-9]+$/", $hp)) {
        $error["hp"] = "Nomor HP hanya boleh angka";
        return;
    }
}

function validateLevel(&$error, $level)
{
    if ($level != 1 && $level != 2) {
        $error["level"] = "Level wajib dipilih";
        return;
    }
}
?>
