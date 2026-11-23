<?php
$errors = array();

if (isset($_POST['surname'])) {
    require 'validate.inc';

    validateName($errors, $_POST, 'surname');
    validateEmail($errors, $_POST, 'email');
    validateGender($errors, $_POST, 'gender');

    if ($errors) {
        echo '<h3>Invalid, correct the following errors:</h3>';

        foreach ($errors as $field => $error) {
            echo htmlspecialchars($field) . ' ' .
                 htmlspecialchars($error) . '<br>';
        }

        include 'form.inc';
    } else {
        echo '<h3>Form submitted successfully with no errors</h3>';
    }
} else {
    include 'form.inc';
}
?>
