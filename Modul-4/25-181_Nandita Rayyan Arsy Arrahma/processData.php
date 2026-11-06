<h3>Posted data: </h3>
<?php 
	require 'validate.inc'; $errors = array();
	validateName($errors, $_POST, 'surname'); if ($errors) {
		echo 'Errors:<br/>';
		foreach ($errors as $field => $error)
	echo "$field $error</br>";
	} else {
		echo 'Data OK!';
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		foreach ($_POST as $key => $value) {
			if (is_array($value)) {
				$value = implode(",", $value);
			}
			echo "($key) => ($value)<br>";
		}
	} else {
		echo "Tidak ada data yang Terkirim.";
	}
?>