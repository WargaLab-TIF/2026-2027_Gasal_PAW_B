<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <title>Process Data</title>
</head>
<body>
<h3>Posted data: </h3>
<?php
foreach ($_POST as $key => $value)
    echo "($key) => ($value)<br/>";
?>
</body>
</html>
