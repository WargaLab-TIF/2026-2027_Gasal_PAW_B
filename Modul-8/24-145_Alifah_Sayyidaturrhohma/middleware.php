<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function cekLogin() {
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
        header("Location: login.php");
        exit;
    }
}

function cekOwner() {

    cekLogin();

    if (!isset($_SESSION['level']) || (int)$_SESSION['level'] !== 1) {
        echo "<script>
            alert('Akses ditolak! Halaman ini hanya dapat diakses oleh Owner.');
            window.location.href = 'index.php';
        </script>";
        exit;
    }
}

function cekSudahLogin() {
    if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
        header("Location: index.php");
        exit;
    }
}
?>

