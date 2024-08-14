<?php

require_once 'ex7.php';

function getDaysUnderTempDictionary(float $targetTemp): array {
    $inputFile = fopen(__DIR__ . '/data/temperatures-filtered.csv', "r");
    $years = [];
    $daysUnderTempDict = [];

    while(($dict = fgetcsv($inputFile)) !== false) {
        $year = intval($dict[0]);

        if (!$dict || !is_numeric($dict[0])) {
            continue;
        }

        if (!in_array($year, $years)) {
            $years[] = $year;
        }
    }

    fclose($inputFile);

    foreach ($years as $year) {
        $daysUnderTempDict[$year] = getDaysUnderTemp($year, $targetTemp);
    }

    return $daysUnderTempDict;
}

function dictToString(array $dict): string {
    $result = '[';

    foreach ($dict as $year => $days) {
        $result .= "$year => $days, ";
    }

    $result = rtrim($result, ", ");
    $result .= ']';

    return $result;
}