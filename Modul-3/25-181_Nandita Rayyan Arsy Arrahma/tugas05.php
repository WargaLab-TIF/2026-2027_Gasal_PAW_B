<?php 
	$students = array(
		array("Alex","220401","0812345678"),
		array("Bianca","220402","0812345687"),
		array("Candice","220403","0812345665")
	);

	//menampilkan data awal dulu ini:

	echo "Data awal: <br>";
	echo "students = ( <br>";

	foreach ($students as $row) {
		echo "(";
		foreach ($row as $item) {
			echo '"' . $item . '" ,';
		}
		echo "), <br>";
	}
	echo ") <br><br>";

	//menambahkan data baru:

	$students[] = array("Daniel","220404","0812345611");
	$students[] = array("Elena","220405","0812345622");
	$students[] = array("Fiona","220406","0812345633");
	$students[] = array("Gabe","220407","0812345644");
	$students[] = array("Hannah","220408","0812345655");

	echo "Data setelah ditambah 5 data lain: <br>";
	echo "students = ( <br>";

	foreach ($students as $row) {
		echo "(";
		foreach ($row as $item) {
			echo '"' . $item . '" ,';
		}
		echo "), <br>";
	}
	echo ") <br><br>";

	//menampilkan data berupa tabel:

	echo "<table border='1' cellpadding='8' cellspacing='0'>";
	echo "<tr>
			<th>Nama</th>
			<th>Nim</th>
			<th>Mobile</th>
		</tr>";

	foreach ($students as $row) {
		echo "<tr>";
		echo "<td>" . $row[0] . "</td>";
		echo "<td>" . $row[1] . "</td>";
		echo "<td>" . $row[2] . "</td>";
 		echo "</tr>";
	}
	echo "</table>";
?>