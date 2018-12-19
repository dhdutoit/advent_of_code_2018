<?php

$input = file('input');
$clothSquare = array_fill(0, 1008, array_fill(0, 1008, '.'));
$squareInches = 0;

foreach ($input as $row) {
    if (empty($row)) { continue; }

    $details = explode(" ", preg_replace("/[#@,:x]/", " ",trim($row)));

    $x = $details[5];
    $y = $details[4];
    $width = $x + $details[8];
    $height = $y + $details[7];

    for ($xPos=$x; $xPos<$width; $xPos++) {
        for ($yPos=$y; $yPos<$height; $yPos++) {
            if ($clothSquare[$xPos][$yPos] === ".") {
                $clothSquare[$xPos][$yPos] = $details[1];
            } else {
                $clothSquare[$xPos][$yPos] = "x";
            }
        }
    }
}

foreach ($clothSquare as $row) {
    foreach ($row as $square) {
        if ($square === "x") {
            $squareInches++;
        }
    }
}

echo "\n" . $squareInches . "\n";

// my answer for part 1 = 103482
