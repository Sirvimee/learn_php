<?php

$list = [1, 2, 3];

function listToString(array $list): string {
    $list = implode(", ", $list);
    return "[$list]";
}