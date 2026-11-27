<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: login.php');
    exit;
}

function hanya_owner(): void
{
    if (!isset($_SESSION['level']) || (int) $_SESSION['level'] !== 1) {
        http_response_code(403);
        exit('Akses ditolak. Halaman ini hanya dapat diakses oleh Owner.');
    }
}
