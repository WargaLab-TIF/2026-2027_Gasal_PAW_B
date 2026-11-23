<?php
$height = array("Andy"=>"176", "Barry"=>"165", "Charlie"=>"170");
$height["David"]="180";
$height["Ethan"]="172";
$height["Frank"]="168";
$height["George"]="175";
$height["Harry"]="182";
echo "height = ";
print_r($height);
foreach($height as $nama=>$tinggi){
    echo "<br>$nama is $tinggi cm tall";
}
 ?>