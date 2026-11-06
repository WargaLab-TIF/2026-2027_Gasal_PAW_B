<html>
<body>
<h3>Posted data: </h3>
<?php
foreach ($_POST as $key => $value)
    echo "($key) => ($value)<br/>";

/*
Pengujian method GET (ubah atribut method di form menjadi "GET"):

foreach ($_GET as $key => $value)
    echo "($key) => ($value)<br/>";

Perbedaan: pada GET data muncul di URL (query string) dan terlihat di tab Network
bagian Query String Parameters, sedangkan pada POST data tidak muncul di URL
dan ada di bagian Form Data / Payload.
*/

/*
Mengambil satu field saja:

$surname = $_POST['surname'];
echo $surname;
*/
?>
</body>
</html>
