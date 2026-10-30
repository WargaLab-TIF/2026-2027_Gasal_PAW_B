<!DOCTYPE html>
<html>
<body>
    <fieldset>
        <legend>Person Detail</legend>
        <?php
            require 'validate.inc';
            $errors = array();

            if (isset($_POST['submit'])) {
                validateForm($errors, $_POST);

                if ($errors) {
                    echo '<h3>Invalid, correct the following errors:</h3>';
                } else {
                    echo 'Form submitted successfully with no errors <br>';
                    foreach ($_POST as $key => $value) {
                        echo "($key) => ($value)<br>";
                    }
                }
            }

            // tampilkan form jika belum disubmit atau masih ada error
            if (!isset($_POST['submit']) || $errors) {
                include 'form.inc';
            }
        ?>
    </fieldset>
</body>
</html>