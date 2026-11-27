<?php
require_once 'auth.php';
require_owner();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Master</title>
    <style>
        body { font-family: Arial; background: whitesmoke; margin: 30px; color: darkslategray; }
        a { display: inline-block; background: cadetblue; color: white; padding: 12px 18px; margin: 8px; text-decoration: none; border-radius: 5px; }
        h2 { color: cadetblue; }
    </style>
</head>
<body>
<h2>Data Master</h2>
<a href="index.php">Home</a>
<a href="barang.php">Data Barang</a>
<a href="supplier.php">Data Supplier</a>
<a href="pelanggan.php">Data Pelanggan</a>
<a href="user.php">Data User</a>
</body>
</html>
