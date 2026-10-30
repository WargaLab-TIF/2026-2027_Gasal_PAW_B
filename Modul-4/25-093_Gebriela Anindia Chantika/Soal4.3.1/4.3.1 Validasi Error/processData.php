
<?php
require 'validate.inc';

$errors = array();

validateName($errors, $_POST, 'surname');

if ($errors) {
    echo 'Errors:<br>';

    foreach ($errors as $field => $error) {
        echo htmlspecialchars($field) . ' '
           . htmlspecialchars($error) . '<br>';
    }
} else {
    echo 'Data OK!';
}
?>
