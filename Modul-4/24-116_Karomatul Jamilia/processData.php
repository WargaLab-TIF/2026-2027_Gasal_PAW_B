<h3>Posted Data</h3>
<?php
	require 'validate.inc'; 
	$errors = array();
	validateName($errors, $_POST, 'surname');

	if ($errors) {
	    echo 'Errors:<br/>';

	    foreach ($errors as $field => $error) {
	        echo "$field $error<br/>";
	    }
	} else {
	    echo 'Data OK!<br>';
	}

	// foreach ($_POST as $key => $value) {
	// 	echo "($key) => ($value) <br/>";
	// 	$surname = $_POST['surname'];
	// }
?>


