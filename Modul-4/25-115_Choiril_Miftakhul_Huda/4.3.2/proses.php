<!-- <?php
	// $errors = array();
	// if (isset($_POST['surname'])){
	// 	require 'validate.inc';
	// 	validateName($errors, $_POST, 'surname');

	// 	if ($errors){
	// 		echo '<h1>Invalid, correct the following errors:</h1>';
	// 		foreach ($errors as $field => $error){
	// 			echo "$field $error<br>";
	// 		}
	// 		// Tampilkan kembali form
	// 		include 'form.inc';
	// 	} else {
	// 		echo 'Form submitted successfully with no errors';
	// 	}
	// } else {
	// 	// Tampilkan kembali form 
	// 	include 'form.inc';
	// }
?> -->

<?php
    require 'validate.inc';
    $errors = array();

    if (isset($_POST['submit'])) {
        validateForm($errors, $_POST);

        if ($errors) {
            echo '<h3>Invalid, correct the following errors:</h3>';
            foreach ($_POST as $key => $value) {
                echo "($key) => ($value)<br>";
            }
        } else {
            echo 'Form submitted successfully with no errors <br>';
            foreach ($_POST as $key => $value) {
                echo "($key) => ($value)<br>";
            }
        }
    }

    // tampilkan kembali form 
    if (!isset($_POST['submit']) || $errors) {
        include 'form.inc';
    }
?>