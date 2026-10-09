
<?php
    $height = array(
        "Andy" => "176",
        "Barry" => "165",
        "Charlie" => "170"
    );

    $height["David"] = "180";
    $height["Ethan"] = "172";
    $height["Frank"] = "168";
    $height["George"] = "175";
    $height["Harry"] = "182";

    

    $i = 0;
    $total = count($height);

    echo 'height = ( ';
    foreach ($height as $name => $value) {
        echo '"' . $name . '" => "' . $value . '"';

        if ($i < $total - 1) {
            echo ', ';
        }

        $i++;

        $lastvalue = $value;
    }
    echo ' )<br>';

    echo "Nilai dengan indeks terakhir: ". $lastvalue."<br><br>";



    unset($height['Barry']);
    $j = 0;
    $total2 = count($height);
    echo 'height = ( ';
    foreach ($height as $name => $value) {
        echo '"' . $name .'" => "' . $value . '"';

        if ($j < $total2 - 1) {
            echo ', ';
        }

        $j++;

        $lastvalue2 = $value;
    }
    echo ' )<br>';

    echo "Nilai dengan indeks terakhir setelah dihapus: ". $lastvalue2;

?>