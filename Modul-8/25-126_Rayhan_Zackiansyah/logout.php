<?php
include 'koneksi.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $_SESSION = [];
  session_destroy();
}
header('Location: login.php');
exit;
?>
