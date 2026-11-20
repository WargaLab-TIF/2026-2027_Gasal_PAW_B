<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function wajibLogin() {
    if (!isset($_SESSION['id_user'])) {
        header("Location: login.php");
        exit;
    }
}

function khususOwner() {
    wajibLogin();

    if ($_SESSION['level'] != 1) {
        header("Location: index.php");
        exit;
    }
}

function sudahLogin() {
    if (isset($_SESSION['id_user'])) {
        header("Location: index.php");
        exit;
    }
}
?>