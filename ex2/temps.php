<?php

require_once '../ex1/ex7.php'; // use existing code
require_once '../ex1/ex8.php';
require_once 'functions.php'; // separate functions from main program

$opts = getopt('c:y:t:', ['command:', 'year:', 'temp:']);

$command = $opts['command'] ?? null;

if ($command === 'days-under-temp') {
    if (!isset($opts['year']) || !isset($opts['temp'])) {
        showError('year and temp are required parameters');
    } else {
        $year = intval($opts['year']);
        $temp = floatval($opts['temp']);
        $result = getDaysUnderTemp($year, $temp);
        echo $result;
    }

} else if ($command === 'days-under-temp-dict') {
    if (!isset($opts['temp'])) {
        showError('temp is a required parameter');
    } else {
        $temp = floatval($opts['temp']);
        $result = getDaysUnderTempDictionary($temp);
        echo dictToString($result);
    }
} else if ($command === 'avg-winter-temp') {
    if (!isset($opts['year'])) {
        showError('temp is a required parameter');
    } else {
        $years = explode('/', $opts['year']);
        $startYear = intval($years[0]);
        $endYear = intval($years[1]);
        $result = getAverageWinterTemp($startYear, $endYear);
        echo $result;
    }

} else {
    showError('command is missing or is unknown');
}

function showError(string $message): void {
    fwrite(STDERR, $message . PHP_EOL);
    exit(1);
}