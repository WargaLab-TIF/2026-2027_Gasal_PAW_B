<?php
$student = array(
array("Alex","220401", "0812345678"),
array("Bianca","220402", "0812345687"),
array("Candice","220403", "0812345665"),
);

$student2 = array(
array("Daniel", "220404", "0812345611"),
array("Elena", "220405", "0812345622"),
array("Fiona", "220406", "0812345633"),
array("Gabe", "220407", "0812345644"),
array("Hannah", "220408", "0812345655"),
);

$final_student = array_merge($student, $student2);

echo "Data awal: <br>";
print_r($student);

echo "<br><br>";
echo "Data setelah ditambah 5 data lain: <br>";
print_r($final_student);

echo "<br><br>";

echo "<table border='1'><tr><th>Nama</th><th>NIM</th><th>Mobile</th></tr>";
for ($i=0; $i < count($final_student) ; $i++) { 
	echo "<tr>";
	for ($j=0; $j < count($final_student[0]); $j++) { 
		echo "<td>".$final_student[$i][$j]."</td>";
	}
	echo "</tr>";
}
echo "</table>";
?>