<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

// Halaman Data Master hanya boleh dibuka oleh Owner (level 1).
if (isset($hanya_owner) && (int)($_SESSION['level'] ?? 0) !== 1) {
    header("Location: index.php");
    exit();
}
?>
