<h3>Posted Data:</h3>
<?php
	// require 'validate.inc'; 
	// 	if (validateName($_POST, 'surname')) {
	// 		echo 'Data OK!';
	// 	} else {
	// 		echo 'Data invalid!';
	// 	}

    require 'validate.inc';
    $errors = array();
    validateForm($errors, $_POST);

    if ($errors) {
        echo 'Errors:<br/>';
        foreach ($errors as $field => $error) {
            echo "$field: $error<br/>";
        }
    } else {
        echo 'Data OK!<br/>';
    }

    foreach ($_POST as $key => $value) {
        echo "($key) => ($value)<br>";
    }
?>