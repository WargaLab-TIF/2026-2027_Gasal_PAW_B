<?php
$students = array(
    array("Alex", "220401", "0812345678"),
    array("Bianca", "220402", "0812345687"),
    array("Candice", "220403", "0812345665")
);

echo "Data awal:<br>";
echo "students = ( <br>";

foreach ($students as $student) {
    echo '("' . $student[0] . '", "' . $student[1] . '", "' . $student[2] . '"),<br>';
}

echo ")<br><br>";

$students[] = array("Daniel", "220404", "0812345671");
$students[] = array("Elena", "220405", "0812345672");
$students[] = array("Fiona", "220406", "0812345673");
$students[] = array("Gabe", "220407", "0812345674");
$students[] = array("Hannah", "220408", "0812345655");

echo "Data setelah ditambah 5 data:<br>";
echo "students = ( <br>";

foreach ($students as $student) {
    echo '("' . $student[0] . '", "' . $student[1] . '", "' . $student[2] . '"),<br>';
}

echo ")<br><br>";
?>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Name</th>
        <th>NIM</th>
        <th>Mobile</th>
    </tr>

    <?php
    foreach ($students as $student) {
        echo "<tr>";
        echo "<td>" . $student[0] . "</td>";
        echo "<td>" . $student[1] . "</td>";
        echo "<td>" . $student[2] . "</td>";
        echo "</tr>";
    }
    ?>
</table>