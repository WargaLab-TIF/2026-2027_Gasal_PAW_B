<?php
require "koneksi.php";
include "midlewire.php";

function bersih($teks){
    global $connect;
    return mysqli_real_escape_string($connect, $teks);
}

function cekOwner(){
    if ($_SESSION["level"] != 1) {
        header("Location: index.php");
        exit();
    }
}

function cekTabel($tabel){
    if (!in_array($tabel, ["barang", "supplier", "pelanggan", "user"])) {
        header("Location: index.php");
        exit();
    }
}

function ambilInput(){
    $data = array_map("trim", $_POST);
    $data["password"] = $_POST["password"] ?? "";
    return $data;
}

function selectQuery($query){
    global $connect;
    $result = mysqli_query($connect, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function selectOne($query){
    global $connect;
    $result = mysqli_query($connect, $query);
    return mysqli_fetch_assoc($result);
}

function getBarangWithSupplier(){
    $query = "
    SELECT
        b.*,
        s.nama AS nama_supplier
    FROM barang b
    JOIN supplier s ON
    b.supplier_id = s.id
    ";
    return selectQuery($query);
}

function getSupplier(){
    return selectQuery("SELECT * FROM supplier");
}

function getPelanggan(){
    return selectQuery("SELECT * FROM pelanggan");
}

function getUser(){
    return selectQuery("SELECT * FROM users");
}

function getTransaksi(){
    return selectQuery("SELECT * FROM transaksi");
}

function getDetailTransaksi($id){
    $id = (int) $id;
    $query = "
    SELECT
        b.nama_barang,
        d.harga,
        d.qty
    FROM transaksi_detail d
    JOIN barang b ON
    b.id = d.barang_id
    WHERE d.transaksi_id=$id
    ";
    return selectQuery($query);
}

function getBarangBelumDipakai($id){
    $id = (int) $id;
    $query = "
    SELECT
        *
    FROM barang
    WHERE id NOT IN (SELECT barang_id FROM transaksi_detail WHERE transaksi_id=$id)
    ";
    return selectQuery($query);
}

function getLaporan(){
    $query = "
    SELECT
        b.kode_barang,
        b.nama_barang,
        SUM(d.qty) AS jumlah,
        SUM(d.qty * d.harga) AS pendapatan
    FROM transaksi_detail d
    JOIN barang b ON
    b.id = d.barang_id
    GROUP BY b.id, b.kode_barang, b.nama_barang
    ORDER BY pendapatan DESC
    ";
    return selectQuery($query);
}

function select_barang($id){
    $id = (int) $id;
    return selectOne("SELECT * FROM barang WHERE id=$id");
}

function select_supplier($id){
    $id = (int) $id;
    return selectOne("SELECT * FROM supplier WHERE id=$id");
}

function select_pelanggan($id){
    $id = bersih($id);
    return selectOne("SELECT * FROM pelanggan WHERE id='$id'");
}

function select_user($id){
    $id = (int) $id;
    return selectOne("SELECT *, id_user AS id FROM users WHERE id_user=$id");
}

function select_transaksi($id){
    $id = (int) $id;
    return selectOne("SELECT * FROM transaksi WHERE id=$id");
}

function barangDipakai($id){
    $id = (int) $id;
    return (bool) selectOne("SELECT * FROM transaksi_detail WHERE barang_id=$id");
}

function supplierDipakai($id){
    $id = (int) $id;
    return (bool) selectOne("SELECT * FROM barang WHERE supplier_id=$id");
}

function pelangganDipakai($id){
    $id = bersih($id);
    return (bool) selectOne("SELECT * FROM transaksi WHERE pelanggan_id='$id'");
}

function tambah_barang($data){
    global $connect;
    $kode = bersih($data["kode_barang"]);
    $nama = bersih($data["nama_barang"]);
    $harga = (int) $data["harga"];
    $stok = (int) $data["stok"];
    $supplier_id = (int) $data["supplier_id"];
    $query = "INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id)
            VALUES ('$kode', '$nama', '$harga', '$stok', '$supplier_id')";
    mysqli_query($connect, $query);
}

function tambah_supplier($data){
    global $connect;
    $nama = bersih($data["nama"]);
    $telp = bersih($data["telp"]);
    $alamat = bersih($data["alamat"]);

    $query = "INSERT INTO supplier (nama, telp, alamat)
            VALUES ('$nama', '$telp', '$alamat')";

    mysqli_query($connect, $query);
}

function tambah_pelanggan($data){
    global $connect;
    $id = bersih($data["id"]);
    $nama = bersih($data["nama"]);
    $jk = bersih($data["jenis_kelamin"]);
    $telp = bersih($data["telp"]);
    $alamat = bersih($data["alamat"]);
    $query = "INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat)
            VALUES ('$id', '$nama', '$jk', '$telp', '$alamat')";
    mysqli_query($connect, $query);
}

function tambah_user($data){
    global $connect;
    $username = bersih($data["username"]);
    $password = md5($data["password"]);
    $nama = bersih($data["nama"]);
    $alamat = bersih($data["alamat"]);
    $hp = bersih($data["hp"]);
    $level = (int) $data["level"];
    $query = "INSERT INTO users (username, password, nama, alamat, hp, level)
            VALUES ('$username', '$password', '$nama', '$alamat', '$hp', '$level')";
    mysqli_query($connect, $query);
}

function tambah_detail($transaksi_id, $barang_id, $qty){
    global $connect;
    $transaksi_id = (int) $transaksi_id;
    $barang_id = (int) $barang_id;
    $qty = (int) $qty;
    $barang = select_barang($barang_id);
    if (!$barang || $qty < 1) {
        return;
    }
    $harga = $barang["harga"];
    mysqli_query($connect, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES ($transaksi_id, $barang_id, $harga, $qty)");
    mysqli_query($connect, "UPDATE transaksi SET total = (SELECT SUM(harga * qty) FROM transaksi_detail WHERE transaksi_id=$transaksi_id) WHERE id=$transaksi_id");
}

function hapus_barang($id){
    global $connect;
    $id = (int) $id;
    if (barangDipakai($id)) {
        return "Barang tidak bisa dihapus, masih digunakan pada transaksi";
    }
    mysqli_query($connect, "DELETE FROM barang WHERE id=$id");
}

function hapus_supplier($id){
    global $connect;
    $id = (int) $id;

    if (supplierDipakai($id)) {
        return "Supplier tidak bisa dihapus, masih digunakan pada barang";
    }

    mysqli_query($connect, "DELETE FROM supplier WHERE id=$id");
}

function hapus_pelanggan($id){
    global $connect;
    $id = bersih($id);
    if (pelangganDipakai($id)) {
        return "Pelanggan tidak bisa dihapus, masih digunakan pada transaksi";
    }
    mysqli_query($connect, "DELETE FROM pelanggan WHERE id='$id'");
}

function hapus_user($id){
    global $connect;
    $id = (int) $id;
    if ($id == $_SESSION["id_user"]) {
        return "Akun yang sedang login tidak bisa dihapus";
    }
    mysqli_query($connect, "DELETE FROM users WHERE id_user=$id");
}

function update_barang($data){
    global $connect;
    $id = (int) $data["id"];
    $kode = bersih($data["kode_barang"]);
    $nama = bersih($data["nama_barang"]);
    $harga = (int) $data["harga"];
    $stok = (int) $data["stok"];
    $supplier_id = (int) $data["supplier_id"];
    $query = "UPDATE barang SET
            kode_barang='$kode',
            nama_barang='$nama',
            harga='$harga',
            stok='$stok',
            supplier_id='$supplier_id'
            WHERE id=$id";
    mysqli_query($connect, $query);
}

function update_supplier($data){
    global $connect;
    $id = (int) $data["id"];
    $nama = bersih($data["nama"]);
    $telp = bersih($data["telp"]);
    $alamat = bersih($data["alamat"]);

    $query = "UPDATE supplier SET
            nama='$nama',
            telp='$telp',
            alamat='$alamat'
            WHERE id=$id";

    mysqli_query($connect, $query);
}

function update_pelanggan($data)
{
    global $connect;
    $id = bersih($data["id"]);
    $nama = bersih($data["nama"]);
    $jk = bersih($data["jenis_kelamin"]);
    $telp = bersih($data["telp"]);
    $alamat = bersih($data["alamat"]);
    $query = "UPDATE pelanggan SET
            nama='$nama',
            jenis_kelamin='$jk',
            telp='$telp',
            alamat='$alamat'
            WHERE id='$id'";
    mysqli_query($connect, $query);
}

function update_user($data){
    global $connect;
    $id = (int) $data["id"];
    $username = bersih($data["username"]);
    $nama = bersih($data["nama"]);
    $alamat = bersih($data["alamat"]);
    $hp = bersih($data["hp"]);
    $level = (int) $data["level"];
    $ganti = $data["password"] != "" ? "password='" . md5($data["password"]) . "'," : "";
    $query = "UPDATE users SET
            username='$username',
            $ganti
            nama='$nama',
            alamat='$alamat',
            hp='$hp',
            level='$level'
            WHERE id_user=$id";

    mysqli_query($connect, $query);
}

function requiredCheck($field){
    return trim($field) === "";
}

function validateKode(&$error, $kode, $id){
    $pattern = "/^[a-zA-Z0-9]+$/";
    if (requiredCheck($kode)) {
        $error["kode"] = "Kode tidak boleh kosong";
        return;
    }
    if (!preg_match($pattern, $kode)) {
        $error["kode"] = "Kode hanya boleh mengandung huruf dan angka";
        return;
    }
    if (strlen($kode) > 10) {
        $error["kode"] = "Kode maksimal 10 karakter";
        return;
    }
    $k = bersih($kode);
    $id = (int) $id;
    if (selectOne("SELECT id FROM barang WHERE kode_barang='$k' AND id<>$id")) {
        $error["kode"] = "Kode sudah dipakai";
        return;
    }
    return $error;
}

function validateNamaBarang(&$error, $nama){
    $pattern = "/^[a-zA-Z0-9\s]+$/";
    if (requiredCheck($nama)) {
        $error["nama"] = "Nama barang tidak boleh kosong";
        return;
    }
    if (!preg_match($pattern, $nama)) {
        $error["nama"] = "Nama barang hanya boleh mengandung huruf, angka, dan spasi";
        return;
    }
    if (strlen($nama) > 100) {
        $error["nama"] = "Nama barang maksimal 100 karakter";
        return;
    }
    return $error;
}

function validateHarga(&$error, $harga){
    $pattern = "/^[0-9]+$/";
    if (requiredCheck($harga)) {
        $error["harga"] = "Harga tidak boleh kosong";
        return;
    }
    if (!preg_match($pattern, $harga)) {
        $error["harga"] = "Harga hanya boleh mengandung angka";
        return;
    }
    if (strlen($harga) > 9) {
        $error["harga"] = "Harga maksimal 9 digit";
        return;
    }
    return $error;
}

function validateStok(&$error, $stok){
    $pattern = "/^[0-9]+$/";
    if (requiredCheck($stok)) {
        $error["stok"] = "Stok tidak boleh kosong";
        return;
    }
    if (!preg_match($pattern, $stok)) {
        $error["stok"] = "Stok hanya boleh mengandung angka";
        return;
    }
    if (strlen($stok) > 9) {
        $error["stok"] = "Stok maksimal 9 digit";
        return;
    }
    return $error;
}

function validateSupplier(&$error, $supplier_id){
    if (requiredCheck($supplier_id)) {
        $error["supplier"] = "Supplier wajib dipilih";
        return;
    }
    if (!is_numeric($supplier_id)) {
        $error["supplier"] = "Supplier tidak valid";
        return;
    }
    if (!select_supplier($supplier_id)) {
        $error["supplier"] = "Supplier tidak valid";
        return;
    }
    return $error;
}

function validateNama(&$error, $nama, $max){
    $pattern = "/^[a-zA-Z\s.]+$/";
    if (requiredCheck($nama)) {
        $error["nama"] = "Nama tidak boleh kosong";
        return;
    }
    if (!preg_match($pattern, $nama)) {
        $error["nama"] = "Nama hanya boleh mengandung huruf, spasi, dan titik";
        return;
    }
    if (strlen($nama) > $max) {
        $error["nama"] = "Nama maksimal $max karakter";
        return;
    }
    return $error;
}

function validateTelp(&$error, $telp){
    $pattern = "/^[0-9]+$/";
    if (requiredCheck($telp)) {
        $error["telp"] = "Telp tidak boleh kosong";
        return;
    }
    if (!preg_match($pattern, $telp)) {
        $error["telp"] = "Telp hanya boleh mengandung angka";
        return;
    }
    if (strlen($telp) > 12) {
        $error["telp"] = "Telp maksimal 12 digit";
        return;
    }
    return $error;
}

function validateAlamat(&$error, $alamat){
    if (requiredCheck($alamat)) {
        $error["alamat"] = "Alamat tidak boleh kosong";
        return;
    }
    if (strlen($alamat) > 150) {
        $error["alamat"] = "Alamat maksimal 150 karakter";
        return;
    }
    return $error;
}

function validateIdPelanggan(&$error, $id, $aksi){
    $pattern = "/^[a-zA-Z0-9]+$/";
    if (requiredCheck($id)) {
        $error["id"] = "ID tidak boleh kosong";
        return;
    }
    if (!preg_match($pattern, $id)) {
        $error["id"] = "ID hanya boleh mengandung huruf dan angka";
        return;
    }
    if (strlen($id) > 20) {
        $error["id"] = "ID maksimal 20 karakter";
        return;
    }
    if ($aksi === "tambah" && select_pelanggan($id)) {
        $error["id"] = "ID sudah dipakai";
        return;
    }
    return $error;
}

function validateJk(&$error, $jk){
    if (requiredCheck($jk)) {
        $error["jk"] = "Jenis kelamin wajib dipilih";
        return;
    }
    if (!in_array($jk, ["L", "P"])) {
        $error["jk"] = "Jenis kelamin tidak valid";
        return;
    }
    return $error;
}

function validateUsername(&$error, $username, $id){
    $pattern = "/^[a-zA-Z0-9_]+$/";
    if (requiredCheck($username)) {
        $error["username"] = "Username tidak boleh kosong";
        return;
    }
    if (!preg_match($pattern, $username)) {
        $error["username"] = "Username hanya boleh mengandung huruf, angka, dan garis bawah";
        return;
    }
    if (strlen($username) > 30) {
        $error["username"] = "Username maksimal 30 karakter";
        return;
    }
    $u = bersih($username);
    $id = (int) $id;
    if (selectOne("SELECT id_user FROM users WHERE username='$u' AND id_user<>$id")) {
        $error["username"] = "Username sudah dipakai";
        return;
    }
    return $error;
}

function validatePassword(&$error, $password, $aksi){
    if ($aksi === "tambah" && requiredCheck($password)) {
        $error["password"] = "Password tidak boleh kosong";
        return;
    }
    return $error;
}

function validateHp(&$error, $hp){
    $pattern = "/^[0-9]+$/";
    if (requiredCheck($hp)) {
        $error["hp"] = "HP tidak boleh kosong";
        return;
    }
    if (!preg_match($pattern, $hp)) {
        $error["hp"] = "HP hanya boleh mengandung angka";
        return;
    }
    if (strlen($hp) > 20) {
        $error["hp"] = "HP maksimal 20 digit";
        return;
    }
    return $error;
}

function validateLevel(&$error, $level){
    if (requiredCheck($level)) {
        $error["level"] = "Level wajib dipilih";
        return;
    }
    if (!in_array((string) $level, ["1", "2"])) {
        $error["level"] = "Level tidak valid";
        return;
    }
    return $error;
}
?>