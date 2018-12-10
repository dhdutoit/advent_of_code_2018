<?php

$inputData = file('input');
$twice = 0;
$thrice = 0;

foreach ($inputData as $boxId) {
    $countedChars = count_chars($boxId, 1);

    if (false !== array_search(2, $countedChars)) {
        $twice++;
    }
    if (false !== array_search(3, $countedChars)) {
        $thrice++;
    }
}

echo $thrice * $twice . "\n";
