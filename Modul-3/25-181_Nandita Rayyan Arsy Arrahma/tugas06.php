<?php 
	//izin memberi catatan dikomentar kak, karna saya melihat  code saya sendiri semrawut dan pusing

	//array_push
	$arr1 = array("A");
	echo 'Array awal: ("A")<br>';
	array_push($arr1, "B");
	echo 'Hasil array_push: ' . implode(" ", $arr1) . '<br><br>';

	//array_merge
	$arr2 = array("A", "B");
	$arr3 = array("C");
	echo 'Array awal: ("A","B") digabung denngan ("C")<br>';
	$merged = array_merge($arr2, $arr3);
	echo 'Hasil array_marge: ' . implode(" ", $merged) . '<br><br>';

	//array_value
	$arr4 = array("x" => 1, "y" => 2);
	echo 'Array awal: ("x" => 1, "y" => 2)<br>';
	$values = array_values($arr4);
	echo 'Hasil array_values: ' . implode(" ", $values) . '<br><br>';

	//array_search
	$arr5 = array("A", "B", "C");
	echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
	$search = array_search("B", $arr5);
	echo 'Hasil array_search: ' . $search . '<br><br>';

	//array_filter
	$arr6 = array(0, 1, false, 2, "", 3, "array");
	echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
	$filter = array_filter($arr6);
	echo 'Hasil array_filter: ';
	foreach($filter as $val) {
	    echo $val . ' ';
	}
	echo '<br><br>';

	//sort array terindeks
	$arr7 = array(3, 1, 2);
	echo 'Array awal: (3, 1, 2)<br>';

	$arr_sort = $arr7;
	sort($arr_sort);
	echo 'Hasil sort: ' . implode(" ", $arr_sort) . '<br>';

	$arr_rsort = $arr7;
	rsort($arr_rsort);
	echo 'Hasil rsort: ' . implode(" ", $arr_rsort) . '<br><br>';

	//sort array asosiatif
	$arr8 = array("Peter"=>35, "Ben"=>37, "Joe"=>43);
	echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

	// asort dengan output urut naik
	$arr_asort = $arr8;
	asort($arr_asort);
	echo 'Hasil asort: ';
	$out1 = [];
	foreach($arr_asort as $k => $v) { $out1[] = "$k=> $v"; }
	echo implode(", ", $out1) . ',<br>';

	// ksort dengan output berdasarkan key urut naik
	$arr_ksort = $arr8;
	ksort($arr_ksort);
	echo 'Hasil ksort: ';
	$out2 = [];
	foreach($arr_ksort as $k => $v) { $out2[] = "$k=> $v"; }
	echo implode(", ", $out2) . ',<br>';

	// arsort dengan output nilai urut menurun
	$arr_arsort = $arr8;
	arsort($arr_arsort);
	echo 'Hasil arsort: ';
	$out3 = [];
	foreach($arr_arsort as $k => $v) { $out3[] = "$k=> $v"; }
	echo implode(", ", $out3) . ',<br>';

	// krsort dengan output berdasarkan key urut turun
	$arr_krsort = $arr8;
	krsort($arr_krsort);
	echo 'Hasil krsort: ';
	$out4 = [];
	foreach($arr_krsort as $k => $v) { $out4[] = "$k=> $v"; }
	echo implode(", ", $out4) . ',<br>';
?>