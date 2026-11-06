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

	require 'validate.inc';
	$errors = array();
	validateName($errors, $_POST, 'surname');
	validateEmail($errors, $_POST, 'email');
	validateRequired($errors, $_POST, 'passwd');
	validateRequired($errors, $_POST, 'address');
	validateState($errors, $_POST, 'state');
	validateRequired($errors, $_POST, 'sex');
	if ($errors)
	{
		echo 'Errors:<br/>';
		foreach ($errors as $field => $error)
			echo "$field $error</br>";
	}
	else
		echo 'Data OK!';
?>