<?php
$mahasiswa = array(
    array("Alex", "220401", "0812345678"),
    array("Bianca", "220402", "0812345687"),
    array("Candice", "220403", "0812345665"),
    array("Dimas", "220404", "0812345670"),
    array("Eka", "220405", "0812345671"),
    array("Farhan", "220406", "0812345672"),
    array("Gita", "220407", "0812345673"),
    array("Hana", "220408", "0812345674")
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa</title>
</head>
<body>

<h2>Data Mahasiswa</h2>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Name</th>
        <th>NIM</th>
        <th>Mobile</th>
    </tr>

    <?php
    for ($i = 0; $i < count($mahasiswa); $i++) {
        echo "<tr>";
        echo "<td>" . $mahasiswa[$i][0] . "</td>";
        echo "<td>" . $mahasiswa[$i][1] . "</td>";
        echo "<td>" . $mahasiswa[$i][2] . "</td>";
        echo "</tr>";
    }
    ?>

</table>

</body>
</html>