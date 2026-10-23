<?php
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['surname'])) {
        $errors['surname'] = 'harus diisi!';
    }

    if (!empty($errors)) {
        echo '<h1>Invalid, correct the following errors:</h1>';
        foreach ($errors as $field => $error) {
            echo "$field $error<br/>";
        }
        include 'form.inc';
        
    } else {
        echo 'Form submitted successfully with no errors<br><br>';

        foreach ($_POST as $key => $value) {
            if (is_array($value)) {
                $value = implode(",", $value);
            }
            echo "($key) => ($value)<br>";
        }
    }

} else {
    include 'form.inc';
}
?>