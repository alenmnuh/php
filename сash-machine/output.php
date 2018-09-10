<?php

error_reporting(-1);

$summa = filter_input(INPUT_POST, 'summa') ? filter_input(INPUT_POST, 'summa') :  "error";

echo $summa . "грн<br>";

$nominalArray = [20, 50, 100, 200, 500];
$result = [];

if ((($summa % 50) == 0) && ($summa >= 50) ) {
    getNominalAndCount($summa, $nominalArray, $result);
    foreach ($result as $nominal => $value) {
        print json_encode($result[$nominal]);
    }
} elseif ($summa < 50) {
    echo "Введите сумму больше 50грн<br>";
} elseif (($summa % 50) != 0) {
    echo "Введите сумму кратную числу 50<br>";
}

function getNominalAndCount($summa, $nominalArray, &$result)
{
    $nominal = array_pop($nominalArray);

    if (!($summa >= $nominal)) {
        $nominal = array_pop($nominalArray);
    }

    if ($summa % $nominal)
        list($total, $rest) = explode('.', $summa / $nominal);
    else
        $total = $summa / $nominal;

    array_push($result, [$nominal => $total]);

    if (isset($rest)) {
        $rest = $summa - $total * $nominal;
        getNominalAndCount($rest, $nominalArray, $result);
    }
}