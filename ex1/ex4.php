<?php

$input = '[1, 4, 2, 0]';

function stringToIntegerList(string $input): array {

    $brackets = array("[", "]");
    $str = str_replace($brackets, "", $input);
    $str_list = explode(", ", $str);

    return array_map('intval', $str_list);
}

