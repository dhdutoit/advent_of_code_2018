<?php

$input = file('test_input');

// build ordered list of data
$sortedData = [];
foreach ($input as $timeEvent) {
    $result = [];
    preg_match("/\[([^]]+)\]/", $timeEvent, $result);
    $sortedData[$result[1]] = str_replace($result[0],'',$timeEvent);
}
ksort($sortedData);
print_r($sortedData);

//next: find guard IDs
//then: find sleep minutes totals
//then: find most sleping guard
//then: find most used sleep minute

// var_dump($input);
