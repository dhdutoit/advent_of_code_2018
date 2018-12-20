<?php

// $input = file('input');
$input = file('test_input');

// build ordered list of data
$sortedData = [];
foreach ($input as $timeEvent) {
    $result = [];
    preg_match("/\[([^]]+)\]/", $timeEvent, $result);
    $sortedData[strtotime($result[1])] = str_replace($result[0],'',$timeEvent);
}
ksort($sortedData);
$sortedData = array_map('trim', $sortedData);

var_dump($sortedData);

// get schedules organised
$guardSchedules = [];
foreach ($sortedData as $key => $event) {

    if (preg_match("/Guard\s#\d+/", $event)) {
        if (!key_exists($event, $guardSchedules)) {
            $currentGuard = $event;
            $guardSchedules[$currentGuard] = [];
        }
    } else {
        $date = ((new DateTime())->setTimestamp($key))->format("Y-m-d H:i");
        $guardSchedules[$currentGuard][$date] = $event;
    }

}

//calculate sleeping for each
foreach ($guardSchedules as $guard => $schedule) {
    $sleep;
    $totalSleep = 0;
    foreach ($schedule as $timeStamp => $event) {
        if ("wakes up" === $event) {
            $period = (new DateTime($sleep))->diff(new DateTime($timeStamp));
            $totalSleep += $period->format('%i');
        } else {
            $sleep = $timeStamp;
        }
    }
    echo "--total sleep : " . $totalSleep . "\n";
}

print_r($guardSchedules);


//next: find guard IDs
// $guards = preg_grep("/Guard\s#\d+/", $sortedData);
// print_r($guards);
// echo array_search("Guard #10 begins shift", $guards);


echo "done....." . count($sortedData) . PHP_EOL;


//then: find sleep minutes totals
//then: find most sleping guard
//then: find most used sleep minute

// var_dump($input);
