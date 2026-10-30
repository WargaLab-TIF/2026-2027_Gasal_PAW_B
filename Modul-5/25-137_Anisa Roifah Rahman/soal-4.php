<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {

    $id = $_POST['id'];

    $query = "DELETE FROM supplier WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        header("Location: soal-1.php");
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }

} else {
    header("Location: soal-1.php");
    exit;
}
?>

<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {

    $id = $_POST['id'];

    $query = "DELETE FROM supplier WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        header("Location: soal-1.php");
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }

} else {
    header("Location: soal-1.php");
    exit;
}
?>