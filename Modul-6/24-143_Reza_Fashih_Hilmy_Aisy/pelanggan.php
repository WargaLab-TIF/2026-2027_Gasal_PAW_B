<?php
include "koneksi.php";

$query = mysqli_query($conn, "SELECT * FROM pelanggan");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pelanggan</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: whitesmoke;
        margin: 30px;
        color: darkslategray;
    }

    h2 {
        color: cadetblue;
    }

    a {
        display: inline-block;
        background-color: cadetblue;
        color: white;
        text-decoration: none;
        padding: 8px 12px;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    a:hover {
        background-color: darkslategray;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
    }

    th {
        background-color: lightblue;
    }

    th, td {
        border: 1px solid lightgray;
        padding: 10px;
        text-align: left;
    }

    tr:hover {
        background-color: aliceblue;
    }
</style>
</head>
<body>

<h2>Data Pelanggan</h2>

<a href="index.php">Kembali</a>

<table>
    <tr>
        <th>ID</th>
        <th>Nama Pelanggan</th>
        <th>Telepon</th>
        <th>Alamat</th>
    </tr>

    <?php
    while ($data = mysqli_fetch_assoc($query)) {
    ?>
    <tr>
        <td><?= $data['id'] ?></td>
        <td><?= $data['nama'] ?></td>
        <td><?= $data['telp'] ?></td>
        <td><?= $data['alamat'] ?></td>
    </tr>
    <?php
    }
    ?>
</table>

</body>
</html>
