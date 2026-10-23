<?php
$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'validate.inc';

    validateName($errors, $_POST, 'surname');
    validateEmail($errors, $_POST, 'email');

    if ($errors) {
        echo '<h2>Invalid, correct the following errors:</h2>';

        foreach ($errors as $field => $error) {
            echo htmlspecialchars($field) . ' ' .
                 htmlspecialchars($error) . '<br>';
        }
    } else {
        echo 'Form submitted successfully with no errors';
    }
}

include 'form.inc';
?>