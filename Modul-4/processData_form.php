<?php
$errors = array();

if (isset($_POST['surname'])) {
    require 'validate.inc';

    validateName($errors, $_POST, 'surname');
    validateEmail($errors, $_POST, 'email');

    if ($errors) {
        echo '<h2>Invalid, correct the following errors:</h2>';

        foreach ($errors as $field => $error) {
            echo "$field $error<br>";
        }

        include 'form.inc';
    } else {
        echo 'Form submitted successfully with no errors';
        include 'form.inc';
    }
} else {
    include 'form.inc';
}
?>