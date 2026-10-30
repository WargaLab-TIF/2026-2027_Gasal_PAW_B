
<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Silakan isi form terlebih dahulu.";
    exit;
}

require_once 'validate1.inc';

if (validateName($_POST, 'surname')) {
    echo "Data OK!";
} else {
    echo "Data invalid!";
}
?>
