<?php
require 'validate.inc';

$errors = array();
if (isset($_POST['surname'])) {
    validateName($errors, $_POST, 'surname');
    if ($errors) {
        echo '<h1>Invalid, correct the following errors:</h1>';
        foreach ($errors as $field => $error)
            echo "$field $error</br>";
    } else {
        echo 'Data OK!';
    }
}
?>
<h3>Posted data:</h3>
<?php
foreach ($_POST as $key => $value)
    echo "($key) => ($value)<br/>";
?>