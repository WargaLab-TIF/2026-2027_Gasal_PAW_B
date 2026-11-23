<?php
if (!isset($_SESSION['id_user'], $_SESSION['nama'], $_SESSION['level'])) {
    header('Location: login.php');
    exit;
}
if (isset($owner_only) && $_SESSION['level'] != 1) {
    header('Location: index.php');
    exit;
}
