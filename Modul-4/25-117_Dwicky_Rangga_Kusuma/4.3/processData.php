<h3>Posted Data: </h3>
<?php
echo "<h1>Form Data</h1>";

foreach ($_POST as $field => $value)
{
    echo "($field) => ($value)<br/>";
}
// Perbedaan GET dan POST adalah GET menempatkan data pada query string URL sedangkan POST menempatkan data pada body HTTP request. Perbedaan ini dapat diamati melalui Developer Tools (F12) pada tab Network.
 ?>