<?php

$start = microtime(true);
$input = file('input');
// $input = file('test_input');
$clothSquare = array_fill(0, 1008, array_fill(0, 1008, '.'));
// $clothSquare = array_fill(0, 8, array_fill(0, 8, '.'));
$squareInches = 0;
$touched = [];
$claimIdList = [];

foreach ($input as $row) {
    if (empty($row)) { continue; }

    $details = explode(" ", preg_replace("/[#@,:x]/", " ",trim($row)));

    $x = $details[5];
    $y = $details[4];
    $width = $x + $details[8];
    $height = $y + $details[7];
    $claimId = $details[1];

    //just track the IDs
    $claimIdList[] = $claimId;

    for ($xPos=$x; $xPos<$width; $xPos++) {
        for ($yPos=$y; $yPos<$height; $yPos++) {
            $square = $clothSquare[$xPos][$yPos];

            if ($square === ".") {
                $clothSquare[$xPos][$yPos] = $claimId;
            } else if ($square !== "x") {

                // get claim ID that has conflicts with others
                if (!in_array($square, $touched)) {
                    $touched[] = $square;
                }
                if (!in_array($claimId, $touched)) {
                    $touched[] = $claimId;
                }
                $squareInches++;
                $clothSquare[$xPos][$yPos] = "x";
            }
        }
    }
}

// foreach ($clothSquare as $row) {
//     foreach ($row as $square) {
//         if ($square === "x") {
//             $squareInches++;
//         }
//     }
// }

echo "\npart 1 answer : " . $squareInches . PHP_EOL;

echo "\npart 2 answer : " . current(array_diff($claimIdList, $touched))  . PHP_EOL;

echo "That took " . (microtime(true) - $start) . " seconds." . PHP_EOL;

// my answer for part 1 = 103482
// my answer for part 2 = 686
