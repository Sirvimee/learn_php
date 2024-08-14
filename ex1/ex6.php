<?php

$inputFile = fopen("data/temperatures-sample.csv", "r");
$outputFile = fopen("temperatures-filtered.csv", "w");

while(!feof($inputFile)) {
    $dict = fgetcsv($inputFile);

    if (!$dict || !is_numeric($dict[0])) {
        continue;
    }

    $year = intval($dict[0]);
    $month = $dict[1];
    $day = $dict[2];
    $hour = rtrim($dict[3], ":0");
    $tempt = $dict[9];

    if ($year === 2004 || $year === 2022) {
        fputcsv($outputFile, [$year, $month, $day, $hour, $tempt]);
    }
}

fclose($inputFile);
fclose($outputFile);

