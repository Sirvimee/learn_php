<?php
function getDaysUnderTemp(int $targetYear, float $targetTemp): float {
    $inputFile = fopen(__DIR__ . '/data/temperatures-filtered.csv', "r");
    $totalHoursUnderTemp = 0;

    while (($dict = fgetcsv($inputFile)) !== false) {
        $year = intval($dict[0]);
        $temp = floatval($dict[4]);

        if ($year === $targetYear && $temp <= $targetTemp) {
            $totalHoursUnderTemp++;
        }
    }

    fclose($inputFile);

    $daysUnderTemp = $totalHoursUnderTemp / 24;

    return round($daysUnderTemp, 2);
}
