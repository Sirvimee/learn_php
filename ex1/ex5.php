<?php

$sampleData = [
    ['type' => 'apple', 'weight' => 0.21],
    ['type' => 'orange', 'weight' => 0.18],
    ['type' => 'pear', 'weight' => 0.16],
    ['type' => 'apple', 'weight' => 0.22],
    ['type' => 'orange', 'weight' => 0.15],
    ['type' => 'pear', 'weight' => 0.19],
    ['type' => 'apple', 'weight' => 0.09],
    ['type' => 'orange', 'weight' => 0.24],
    ['type' => 'pear', 'weight' => 0.13],
    ['type' => 'apple', 'weight' => 0.25],
    ['type' => 'orange', 'weight' => 0.08],
    ['type' => 'pear', 'weight' => 0.20],
];

function getAverageWeightsByType(array $list): array {
    $average_weights = [];

    foreach ($list as $item) {
        $average_weights[$item['type']][] = $item['weight'];
    }

    foreach ($average_weights as $type => &$weights) {
        $weights_sum = array_sum($weights);
        $count = count($weights);
        $average_weights[$type] = round($weights_sum / $count, 2);
    }

    return $average_weights;
}