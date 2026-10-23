<?php
$mahasiswa = array(
    array("Alex", "220401", "0812345678"),
    array("Bianca", "220402", "0812345687"),
    array("Candice", "220403", "0812345665"),
    array("Daniel", "220404", "0812345670"),
    array("Emily", "220405", "0812345671"),
    array("Felix", "220406", "0812345672"),
    array("Grace", "220407", "0812345673"),
    array("Henry", "220408", "0812345674")
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

<table border="1">
    <tr>
        <th>Name</th>
        <th>NIM</th>
        <th>Mobile</th>
    </tr>

    <?php
    foreach ($mahasiswa as $data) {
        echo "<tr>";

        foreach ($data as $nilai) {
            echo "<td>" . htmlspecialchars($nilai) . "</td>";
        }

        echo "</tr>";
    }
    ?>
</table>

</body>
</html>
```
