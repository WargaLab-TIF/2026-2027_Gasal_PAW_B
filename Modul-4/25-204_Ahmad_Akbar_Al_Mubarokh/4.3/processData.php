<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<h3>Posted Data: </h3>
</body>
</html>

<?php  
	foreach ($_POST as $key => $value) {
		echo "($key) => ($value)<br/>";
	}
?>