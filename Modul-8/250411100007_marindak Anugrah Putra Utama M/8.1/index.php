<?php include "midlewire.php"; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Halaman Utama</title>
</head>
<body>
	<?php include "components/navbar.php" ?>
	<h1>Selamat datang di perpustakaan, <?= htmlspecialchars($_SESSION['nama']) ?></h1>
	<p>Login sebagai <?= $_SESSION['level'] == 1 ? 'Owner' : 'Kasir' ?>.</p>
</body>
</html>
