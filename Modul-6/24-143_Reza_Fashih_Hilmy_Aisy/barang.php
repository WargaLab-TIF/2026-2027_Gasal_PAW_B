<?php
include "koneksi.php";

$query = mysqli_query($conn, "
    SELECT barang.*, supplier.nama AS nama_supplier
    FROM barang
    INNER JOIN supplier ON barang.supplier_id = supplier.id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
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
        margin-top: 15px;
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

    button {
        background-color: firebrick;
        color: white;
        border: none;
        padding: 7px 12px;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: darkred;
    }

    .error {
        background-color: mistyrose;
        color: firebrick;
        padding: 10px;
        border-radius: 5px;
    }

    .success {
        background-color: honeydew;
        color: seagreen;
        padding: 10px;
        border-radius: 5px;
    }
</style>
</head>
<body>

<h2>Data Barang</h2>

<a href="index.php">Kembali</a>

<?php
if (isset($_GET['status'])) {
    if (isset($_GET['error'])) {
        echo "<p class='error'>" . $_GET['status'] . "</p>";
    } else {
        echo "<p class='success'>" . $_GET['status'] . "</p>";
    }
}
?>

<table>
    <tr>
        <th>ID</th>
        <th>Nama Barang</th>
        <th>Supplier</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Aksi</th>
    </tr>

    <?php
    while ($data = mysqli_fetch_assoc($query)) {
    ?>
    <tr>
        <td><?= $data['id'] ?></td>
        <td><?= $data['nama_barang'] ?></td>
        <td><?= $data['nama_supplier'] ?></td>
        <td><?= $data['harga'] ?></td>
        <td><?= $data['stok'] ?></td>
        <td>
            <form action="hapus_barang.php" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus barang?')">

                <input type="hidden" name="id"
                       value="<?= $data['id'] ?>">

                <button type="submit" class="hapus">Hapus</button>
            </form>
        </td>
    </tr>
    <?php
    }
    ?>
</table>

</body>
</html>