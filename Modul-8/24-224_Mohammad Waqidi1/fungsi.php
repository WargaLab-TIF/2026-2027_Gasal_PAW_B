<?php
require "koneksi.php";
include "midlewire.php";

// functions untuk menampilkan semua data yang ada pada database
function selectAll()
{
    global $connect;
    $query = "SELECT * FROM buku";
    $result = mysqli_query($connect, $query);

    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// functions untuk menampilkan semua data yang ada kategorinya
function getBukuWithKategori()
{
    global $connect;
    $query = "
    SELECT
        b.*,
        kb.nama_kategori
    FROM buku b
    JOIN kategori_buku kb ON
    b.id_kategori_buku = kb.id_kategori_buku
    ";
    $result = mysqli_query($connect, $query);

    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function getKategori()
{
    global $connect;
    $query = "
    SELECT
        *
    FROM kategori_buku
    ";
    $result = mysqli_query($connect, $query);

    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


// functions untuk menampilkan data berdasarkan ID
function select_id($id)
{
    global $connect;
    $query = "SELECT * FROM buku WHERE id_buku=$id";

    $result = mysqli_query($connect, $query);

    return mysqli_fetch_assoc($result);
}

// functions untuk menambahkan data baru
function tambah_buku($judul, $penulis, $tahun, $stok, $id_kategori_buku)
{
    global $connect;

    $query = "INSERT INTO buku (judul, penulis, tahun_terbit, stok, id_kategori_buku)
			VALUES ('$judul', '$penulis', '$tahun', '$stok', '$id_kategori_buku')";

    mysqli_query($connect, $query);
}

// functions untuk menghapus data berdasarkan ID
function hapus_buku($id)
{
    global $connect;
    $query = "DELETE FROM buku WHERE id_buku=$id";

    mysqli_query($connect, $query);
}

// functions untuk mengupdate data berdasarkan ID
function update_buku($id, $judul, $penulis, $terbit, $stok, $id_kategori_buku)
{
    global $connect;
    $query = "UPDATE buku SET
			judul='$judul',
			penulis='$penulis',
			tahun_terbit='$terbit',
			stok='$stok',
            id_kategori_buku='$id_kategori_buku'
			WHERE id_buku=$id";

    mysqli_query($connect, $query);
}

// functions untuk mengecek apakah field kosong atau tidak
function requiredCheck($field)
{
    return trim($field) === "";
}

// functions untuk validate judul
function validateJudul(&$error, $judul)
{
    $pattern = "/^[a-zA-Z0-9\s]+$/";

    if (requiredCheck($judul)) {
        $error["judul"] = "Judul tidak boleh kosong";
        return;
    }

    if (!preg_match($pattern, $judul)) {
        $error["judul"] =
            "Judul hanya boleh mengandung huruf, angka, dan spasi";
        return;
    }
    return $error;
}
function validatePenulis(&$error, $penulis)
{
    $pattern = "/^[a-zA-Z\s]+$/";

    if (requiredCheck($penulis)) {
        $error["penulis"] = "Penulis tidak boleh kosong";
        return;
    }

    if (!preg_match($pattern, $penulis)) {
        $error["penulis"] = "Penulis hanya boleh mengandung huruf";
        return;
    }
    return $error;
}
function validateTahun(&$error, $tahun)
{
    $pattern = "/^[0-9]+$/";

    if (requiredCheck($tahun)) {
        $error["tahun"] = "Tahun tidak boleh kosong";
        return;
    }

    if (!preg_match($pattern, $tahun)) {
        $error["tahun"] = "Tahun hanya boleh mengandung angka";
        return;
    }
    return $error;
}
function validateStok(&$error, $stok)
{
    $pattern = "/^[0-9]+$/";

    if (requiredCheck($stok)) {
        $error["stok"] = "Stok tidak boleh kosong";
        return;
    }

    if ($stok < 0) {
        $error["stok"] =
            "Stok tidak boleh kurang dari 0 atau tidak boleh negative";
        return;
    }

    if (!preg_match($pattern, $stok)) {
        $error["stok"] = "Stok hanya boleh mengandung angka";
        return;
    }

    return $error;
}

function validateKategori(&$error, $kategori){
    if(requiredCheck($kategori)){
        $error["kategori"] = "Kategori wajib di isi";
        return;
    }

    if(!is_numeric($kategori)){
        $error["kategori"] = "Kategori tidak valid";
        return;
    }

    return $error;
}
?>
