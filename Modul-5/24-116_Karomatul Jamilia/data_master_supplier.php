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


function queryDatabase($koneksi, $sql)
{
    $hasil = mysqli_query($koneksi, $sql);

    if (!$hasil) {
        die("Query gagal: " . mysqli_error($koneksi));
    }

    return $hasil;
}

function tampilDataMasterSupplier($hasil){

    
    echo "<div style='width: 100%; font-family: sans-serif; margin-bottom: 20px;'>";
        echo "<div style='display: flex; justify-content: space-between; align-items: center;'>";
            echo "<p style='margin: 0; color: #4682B4; font-size: 18px'>Data Master Supplier</p>";        
                echo "<div style='text-align: left;'>";
                echo "<a href='tambah_data.php' style='background-color: #5cb85c; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-block;'>Tambah Data</a>";
            echo "</div>";
        echo "</div>";
    echo "</div>";

    echo "<table border='1' cellpadding='8' style='width: 100%; border-collapse: collapse; font-family: sans-serif; border: 1px solid #ddd;'>";
    echo "<tr style='background-color: #D9EAF7; text-align: left;'>";
    echo "<th>No</th>";
    echo "<th>Nama</th>";
    echo "<th>Telp</th>";
    echo "<th>Alamat</th>";
    echo "<th>Tindakan</th>";
    echo "</tr>";

    $no = 1;
    while ($row = mysqli_fetch_assoc($hasil)) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . htmlspecialchars($row["Nama"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Telp"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["Alamat"]) . "</td>";
        echo "<td>";
        echo "<a href='edit_data.php?id="
             . $row["id_ms"] . "' style='background-color: #E67E22; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-block;'>Edit</a>  ";
        echo "<a href='hapus_data.php?id="
             . $row["id_ms"] 
             . "' onclick=\"return confirm('Anda yakin ingin menghapus Supplier ini?');\" style='background-color: #C0392B; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; display: inline-block;'>Hapus</a>";
        echo "</td>";

        echo "</tr>";}

    echo "</table>";

}

$koneksi = bukaKoneksi();

$sqlMasterSupplier = "SELECT id_ms, Nama, Telp, Alamat FROM master_supplier";
$tampilMS = queryDatabase($koneksi, $sqlMasterSupplier);

tampilDataMasterSupplier($tampilMS);

mysqli_close($koneksi);

?>