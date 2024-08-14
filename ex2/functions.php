<?php

function getAverageWinterTemp(int $winterStartYear, int $winterEndYear): float {
    $inputFile = fopen(dirname(__DIR__, 1) . '/ex1/data/temperatures-filtered.csv', "r");
    $totalTemperature = 0;
    $totalMonths = 0;

    while (($data = fgetcsv($inputFile)) !== false) {
        $year = intval($data[0]);
        $month = intval($data[1]);
        $temperature = floatval($data[4]);

        if (($year == $winterStartYear && $month == 12) || ($year == $winterEndYear && in_array($month, [1, 2])) || ($year > $winterStartYear && $year < $winterEndYear && in_array($month, [1, 2]))) {
            $totalTemperature += $temperature;
            $totalMonths++;
        }
    }

    fclose($inputFile);

    if ($totalMonths > 0) {
        return round($totalTemperature / $totalMonths, 2);
    } else {
        return 0;
    }
}
