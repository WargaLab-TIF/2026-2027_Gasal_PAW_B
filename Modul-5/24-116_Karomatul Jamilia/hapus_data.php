<?php

function bukaKoneksi()
{
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "db_modul5";

    $koneksi = mysqli_connect($host, $user, $pass, $db);

    if (!$koneksi) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    return $koneksi;
}

function hapusData($koneksi, $id_ms)
    {

    $sql = "DELETE FROM master_supplier
               WHERE id_ms = ?";

    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_ms);

    return mysqli_stmt_execute($stmt);
    }

    $id_ms = $_GET["id"];

    $koneksi = bukaKoneksi();

    if (hapusData($koneksi, $id_ms)) {
        mysqli_close($koneksi);

        header("Location: data_master_supplier.php");
        exit;
    }

    echo "Data gagal dihapus.";

    mysqli_close($koneksi);

?>