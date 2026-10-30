
<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $stmt = mysqli_prepare(
        $conn,
        "DELETE FROM suplier WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

header("Location: index.php");
exit;
?>
