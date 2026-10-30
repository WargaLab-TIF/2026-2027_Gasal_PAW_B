<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<h3>Posted data:</h3>
	<?php
	$errors = array();

	// if (validateName($_POST, 'surname')) {
	// 	echo 'Data OK!';
	// } else {
	// 	echo 'Data invalid!';
	// }

	validateName($errors, $_POST, 'surname');

	if ($errors) {
		echo 'Errors:<br/>';
		foreach ($errors as $field => $error){
			echo "$field $error</br>";
		}
	} else {
		echo "Data OK!<br>";
	}

	foreach ($_POST as $key => $value) {
		echo "($key) => ($value) <br>";
	}
	?>
</body>
</html>

