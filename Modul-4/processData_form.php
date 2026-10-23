<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<h1>Register</h1>
	<fieldset>
		<legend>Person detalier</legend>
<?php
	$errors = array();
	if (isset($_POST['surname']))
	{
		require 'validate.inc';
		validateName($errors, $_POST, 'surname');
		validateEmail($errors, $_POST, 'email');
		validateRequired($errors, $_POST, 'passwd');
		validateRequired($errors, $_POST, 'address');
		validateState($errors, $_POST, 'state');
		validateRequired($errors, $_POST, 'sex');
		if ($errors)
		{
			echo '<h1>Invalid, correct the following errors:</h1>';
			foreach ($errors as $field => $error)
				echo "$field $error</br>";

			// tampilkan kembali form (dengan isian data)
			include 'form.inc';
		}
		else
		{
			echo 'Form submitted successfully with no errors';
		}
	}
	else
		// tampilkan form kosong
		include 'form.inc';
?>
	</fieldset>
</body>
</html>