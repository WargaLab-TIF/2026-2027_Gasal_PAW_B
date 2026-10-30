
<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Silakan isi form terlebih dahulu.";
    exit;
}

require_once 'validate2.inc';

$errors = array();

validateName($errors, $_POST, 'surname');

if ($errors) {
    echo '<h1>Errors:</h1>';

    foreach ($errors as $field => $error) {
        echo htmlspecialchars($field, ENT_QUOTES, 'UTF-8')
            . ' '
            . htmlspecialchars($error, ENT_QUOTES, 'UTF-8')
            . '<br>';
    }
} else {
    echo 'Data OK!';
}
?>
