<h3>Posted Data: </h3>
<?php
echo "<h1>Form Data</h1>";

foreach ($_POST as $field => $value)
{
    echo "($field) => ($value)<br/>";
}
 ?>