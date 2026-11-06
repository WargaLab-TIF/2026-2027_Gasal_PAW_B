<?php
	$errors = array();
	if (isset($_POST['surname'])) 
	{
		require 'validate.inc';
		foreach ($_POST as $keypost => $valuepost) {
			validateName($errors, $_POST, $keypost);
		}

		if ($errors)
			{
				echo '<h1>Invalid, correct the following errors:</h1>';
				foreach ($errors as $field => $error)
				echo "$field $error</br>";
				// tampilkan kembali form
				include 'form.inc';
			}
		else {
			echo 'Form submitted successfully with no errors';
		} 
	} else
	// tampilkan kembali form
	include 'form.inc';
?>