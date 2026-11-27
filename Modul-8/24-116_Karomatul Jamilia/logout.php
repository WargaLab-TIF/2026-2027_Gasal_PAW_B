<?php
session_start();

// unset session lalu kembali ke halaman login
session_unset();
session_destroy();

header("Location: login.php");
exit();
?>
