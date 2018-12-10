<?php

$inputData = file('input');

foreach ($inputData as $boxId) {
    array_walk($inputData, function($nextBoxId, $key, $currentBoxId){
        if (1 == count($diff = array_diff_assoc(
            str_split($currentBoxId),
            str_split($nextBoxId)
        ))) {
            $matchedBoxId = str_replace(current($diff), '', $currentBoxId);
            exit($matchedBoxId);
        }
    }, $boxId);
}
