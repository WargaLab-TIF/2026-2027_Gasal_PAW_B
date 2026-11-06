<?php
	function familyName($fname=""){
	return "$fname<br>";
	};
	$fam1="Jani";
	$fam2="Hege";
	$fam3="Stale";
	$fam4="Kai Jim";
	$fam5="Borge";
	echo familyName($fam1);
	echo familyName($fam2);
	echo familyName($fam3);
	echo familyName($fam4);
	echo familyName($fam5);
?>