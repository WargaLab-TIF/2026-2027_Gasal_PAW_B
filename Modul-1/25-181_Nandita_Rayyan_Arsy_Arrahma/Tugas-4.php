<?php
	$color = "silver";
	$COLOR = "white"; 
?>
<!DOCTYPE html>
<html lang="id">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Tugas 4</title>
	</head>
	<body>
		<h2>My car is <?= htmlspecialchars($color);?></h2>
		<h2>My House is <?= htmlspecialchars($COLOR);?></h2>
	</body>
</html>
