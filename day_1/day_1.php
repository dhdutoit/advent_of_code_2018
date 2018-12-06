<?php

// part 1 solution
// echo array_sum(file('day_1_part_1_input'));

$input = file('day_1_part_2_input');
$frequencyHistory = [];

repeat($input, $frequencyHistory);

function repeat($input, $frequencyHistory, $frequency = 0)
{
    echo ".";

    foreach ($input as $key => $sequence) {
        $frequency += intval($sequence);
        if (in_array($frequency, $frequencyHistory)) {
            echo $frequency . "\n";
            exit;
        }

        $frequencyHistory[] = $frequency;
    }

    repeat($input, $frequencyHistory, $frequency);
}
