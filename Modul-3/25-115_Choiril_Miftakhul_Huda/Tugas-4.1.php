<?php 
$height = array("Andy"=>"176","Barry"=>"165","Charlie"=>"170"); 
$height += array("David"=>"180", "Ethan"=>"172", "Frank"=>"168", "George"=>"175", "Harry"=>"182");
foreach ($height as $key => $value) {
	echo $key . " is " . $value . " cm tall<br>";
}
?>