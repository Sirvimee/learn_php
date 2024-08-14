<?php

ini_set('display_errors', '1');

require_once '../ex1/ex7.php';
require_once '../ex2/functions.php';

$command = $_POST['command'] ?? $_GET['command'] ?? 'show-form';

if ($command === 'show-form') {

    include 'pages/days-under-temp.php';

} else if ($command === 'days-under-temp') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $message = getDaysUnderTemp(intval($_POST['year']), floatval($_POST['temp']));
        include 'pages/result.php';
    } else {
        include 'pages/days-under-temp.php';
    }

} else if ($command === 'avg-winter-temp') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $years = explode('/', $_POST['year']);
        $startYear = intval($years[0]);
        $endYear = intval($years[1]);
        $message = getAverageWinterTemp($startYear, $endYear);
        include 'pages/result.php';
    } else {
        include 'pages/avg-winter-temp.php';
    }

} else {
    throw new Error('unknown command: ' . $command);
}

