<?php
require 'validate.inc';

$errors = array();

validateName($errors, $_POST, 'surname');

if ($errors) {
    echo '<h2>Errors:</h2>';

    foreach ($errors as $field => $error) {
        echo "$field $error<br>";
    }
} else {
    echo 'Data OK!';
}
?>