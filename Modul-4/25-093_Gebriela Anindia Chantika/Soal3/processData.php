
<!DOCTYPE html>
<html>
<head>
    <title>Posted Data</title>
</head>
<body>

<h3>Posted Data:</h3>

<?php
foreach ($_GET as $key => $value) {
    echo "(" . htmlspecialchars($key) . ") => ("
       . htmlspecialchars($value) . ")<br>";
}
?>

</body>
</html>
