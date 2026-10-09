
<?php

    // 1. array_push()
    $iniArray = array('A');

    echo "Array awal: ('A')<br>";

    array_push($iniArray, 'B');

    echo "Hasil array_push: ";
    foreach ($iniArray as $value) {
        echo $value . " ";
    }
    echo "<br><br>";


    // 2. array_merge()
    $array1 = array('A', 'B');
    $array2 = array('C');

    echo "Array awal: ('A', 'B') digabung dengan ('C')<br>";

    $hasilMerge = array_merge($array1, $array2);

    echo "Hasil array_merge: ";
    foreach ($hasilMerge as $value) {
        echo $value . " ";
    }
    echo "<br><br>";


    // 3. array_values()
    $iniArray = array('X' => 1, 'Y' => 2);

    echo "Array awal: ('X' => 1, 'Y' => 2)<br>";

    $hasilValues = array_values($iniArray);

    echo "Hasil array_values: ";
    foreach ($hasilValues as $value) {
        echo $value . " ";
    }
    echo "<br><br>";


    // 4. array_search()
    $iniArray = array('A', 'B', 'C');

    echo "Mencari 'B' pada array ('A', 'B', 'C')<br>";

    $hasilSearch = array_search('B', $iniArray);

    echo "Hasil array_search: " . $hasilSearch;
    echo "<br><br>";


    // 5. array_filter()
    $iniArray = array(0, 1, false, 2, '', 3, 'array');

    echo "Array awal: (0, 1, false, 2, '', 3, 'array')<br>";

    $hasilFilter = array_filter($iniArray);

    echo "Hasil array_filter: ";
    foreach ($hasilFilter as $value) {
        echo $value . " ";
    }
    echo "<br><br>";


    // 6. sort() dan rsort()
    $iniArray = array(3, 1, 2);

    echo "Array awal: (3, 1, 2)<br>";

    $hasilSort = $iniArray;
    sort($hasilSort);

    echo "Hasil sort: ";
    foreach ($hasilSort as $value) {
        echo $value . " ";
    }
    echo "<br>";

    $hasilRsort = $iniArray;
    rsort($hasilRsort);

    echo "Hasil rsort: ";
    foreach ($hasilRsort as $value) {
        echo $value . " ";
    }
    echo "<br><br>";


    // 7. Sorting array asosiatif
    $height = array(
        "Peter" => 35,
        "Ben" => 37,
        "Joe" => 43
    );

    echo "Array awal: ";
    foreach ($height as $key => $value) {
        echo $key . "=>" . $value . ", ";
    }
    echo "<br>";

    // asort()
    $hasilSort = $height;
    asort($hasilSort);

    echo "Hasil asort: ";
    foreach ($hasilSort as $key => $value) {
        echo $key . "=>" . $value . ", ";
    }
    echo "<br>";

    // ksort()
    $hasilKsort = $height;
    ksort($hasilKsort);

    echo "Hasil ksort: ";
    foreach ($hasilKsort as $key => $value) {
        echo $key . "=>" . $value . ", ";
    }
    echo "<br>";

    // arsort()
    $hasilArsort = $height;
    arsort($hasilArsort);

    echo "Hasil arsort: ";
    foreach ($hasilArsort as $key => $value) {
        echo $key . "=>" . $value . ", ";
    }
    echo "<br>";

    // krsort()
    $hasilKrsort = $height;
    krsort($hasilKrsort);

    echo "Hasil krsort: ";
    foreach ($hasilKrsort as $key => $value) {
        echo $key . "=>" . $value . ", ";
    }

?>