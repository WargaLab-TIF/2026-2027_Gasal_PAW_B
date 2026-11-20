<?php
require "fungsi.php";
cekOwner();

$tabel = $_GET["tabel"] ?? "";
cekTabel($tabel);

$hapus = "hapus_" . $tabel;
$pesan = $hapus($_GET["id"] ?? "");

if ($pesan) {
    echo "<script>alert('$pesan'); window.location='index.php?halaman=$tabel'</script>";
    exit();
}

header("Location: index.php?halaman=" . $tabel);
exit();
?>