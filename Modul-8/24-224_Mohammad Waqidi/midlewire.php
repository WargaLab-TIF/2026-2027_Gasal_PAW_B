<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function cek_login($base = "") {
    if (empty($_SESSION['login'])) {
        header("Location: " . $base . "login.php");
        exit();
    }
}

function cek_owner($base = "") {
    cek_login($base);
    if ((int)($_SESSION['level'] ?? 0) !== 1) {
        header("Location: " . $base . "index.php");
        exit();
    }
}
?>
