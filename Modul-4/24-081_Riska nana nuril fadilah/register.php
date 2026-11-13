<?php
$errors = array();

if (isset($_POST['surname'])) {
    require 'validate.inc';

    validateName($errors, $_POST, 'surname');
    validateEmail($errors, $_POST, 'email');
    validateRequired($errors, $_POST, 'password');
    validateRequired($errors, $_POST, 'address');

    if (!isset($_POST['state']) || $_POST['state'] === '-1') {
        $errors['state'] = 'required';
    }

    if (!isset($_POST['sex'])) {
        $errors['sex'] = 'required';
    }

    if ($errors) {
        echo '<h1>Register</h1>';
        echo '<h2>Invalid, correct the following errors:</h2>';

        foreach ($errors as $field => $error) {
            echo htmlspecialchars($field) . ' '
                . htmlspecialchars($error) . '<br>';
        }

        include 'form.inc';
    } else {
        echo '<h1>Register</h1>';
        echo 'Form submitted successfully with no errors';
    }
} else {
    echo '<h1>Register</h1>';
    include 'form.inc';
}
?>