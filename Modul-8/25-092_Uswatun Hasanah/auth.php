<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function cekLogin()
{
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
        header("Location: login.php");
        exit;
    }
}

function cekOwner()
{
    cekLogin();

    if ((int)$_SESSION['level'] !== 1) {
        echo "<script>
            alert('Anda tidak memiliki hak akses!');
            window.location='index.php';
        </script>";
        exit;
    }
}
?>