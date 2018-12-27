<?php

$input = file('input');
// $input = file('test_input');

// build ordered list of data
$sortedData = [];
foreach ($input as $timeEvent) {
    $result = [];
    preg_match("/\[([^]]+)\]/", $timeEvent, $result);
    $sortedData[strtotime($result[1])] = str_replace($result[0],'',$timeEvent);
}
ksort($sortedData);
$sortedData = array_map('trim', $sortedData);

// get schedules organised
$guardSchedules = [];
foreach ($sortedData as $key => $event) {

    if (preg_match("/Guard\s#\d+/", $event)) {

        $currentGuardId = [];
        preg_match('/\d+/', $event, $currentGuardId);
        $currentGuardId = $currentGuardId[0];

        if (!key_exists($currentGuardId, $guardSchedules)) {
            $guardSchedules[$currentGuardId] = [];
        }
    } else {
        $date = ((new DateTime())->setTimestamp($key))->format("Y-m-d H:i");
        $guardSchedules[$currentGuardId][$date] = $event;
    }

}

//calculate sleeping for each
$sleepRecord = [];
$sameMinuteRecord = [];
foreach ($guardSchedules as $guard => $schedule) {

    $sleep;
    $totalSleep = 0;
    $minuteRange = [];

    foreach ($schedule as $timeStamp => $event) {
        if ("wakes up" === $event) {

            $sleepDate = new DateTime($sleep);
            $timeStamp = new DateTime($timeStamp);

            $period = ($sleepDate)->diff($timeStamp);
            $totalSleep += $period->format('%i');

            // get minutes and build a range
            $minuteRange = array_merge($minuteRange, range($sleepDate->format('i'), ($timeStamp->format('i'))-1));

        } else {
            // get the minute he fell asleep on
            $sleep = $timeStamp;
        }
    }

    $minutesSleptIn = array_count_values($minuteRange);
    $minuteCount = max($minutesSleptIn);
    $mostSleptMinute = current(array_keys($minutesSleptIn, $minuteCount));

    //strategy 1
    if ($totalSleep > $sleepRecord[1]) {
        $sleepRecord = [
            $guard,
            $totalSleep,
            $mostSleptMinute,
        ];
    }

    //strategy 2
    if ($minuteCount > $sameMinuteRecord[1]) {
        $sameMinuteRecord = [
            $guard,
            $minuteCount,
            $mostSleptMinute,
        ];
    }
}

$answer = $sleepRecord[0] * $sleepRecord[2];
echo "Strategy 1 - " . $answer . "\n";

$answer = $sameMinuteRecord[0] * $sameMinuteRecord[2];
echo "Strategy 2 - " . $answer . "\n";
