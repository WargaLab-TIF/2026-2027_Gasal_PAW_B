<!DOCTYPE html>
<html>
<head>
    <title>Validation Result</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f5f5f5; }
        .result { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 500px; }
        h1 { color: #333; }
        .error { color: #c62828; }
        .ok { color: #2e7d32; font-weight: bold; }
    </style>
</head>
<body>
    <div class="result">
        <?php
        require 'validate.inc';

        $errors = array();
        validateName($errors, $_POST, 'surname');

        if ($errors) {
            echo '<h1 class="error">Errors:</h1>';
            foreach ($errors as $field => $error)
                echo "<p class='error'>$field $error</p>";
        } else {
            echo '<p class="ok">Data OK!</p>';
        }
        ?>
    </div>
</body>
</html>
