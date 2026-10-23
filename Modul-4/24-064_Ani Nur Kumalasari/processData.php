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
    echo 'Data OK!';
}
foreach ($_POST as $key => $value) 
	echo"($key) => ($value)<br/>";
	$surname = $_POST['surname'];
?>
