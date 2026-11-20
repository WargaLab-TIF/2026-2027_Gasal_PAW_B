<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] != true) {
    header("Location: login.php");
    exit();
}

function cekOwner()
{
    if (!isset($_SESSION['level']) || $_SESSION['level'] != 1) {
        header("Location: index.php");
        exit();
    }
}
?>
