<?php
echo "<h3>Posted Data:</h3>";

foreach ($_POST as $key => $value) {
    echo "(" . htmlspecialchars($key) . ") => (" .
         htmlspecialchars($value) . ")<br>";
}
?>
