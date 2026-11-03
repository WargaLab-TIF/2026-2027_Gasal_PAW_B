<!DOCTYPE html>
<html>
<head>
    <title>Posted Data</title>
</head>
<body>
    <h3>Posted data:</h3>

    <?php
    foreach ($_POST as $key => $value) {
        echo "($key) => ($value) <br/>";
    }
    ?>
</body>
</html>
