<?php

use Carbon\CarbonPeriod;

function workdays($start,$end,$holidays){
    $end = strtotime($end);
    $start = strtotime($start);
    $days = ($end - $start) / 86400 + 1;

    $no_full_weeks = floor($days / 7);
    $no_remaining_days = fmod($days, 7);

    $the_first_day_of_week = date("N", $start);
    $the_last_day_of_week = date("N", $end);

    if ($the_first_day_of_week <= $the_last_day_of_week) {
        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
    }
    else {
        if ($the_first_day_of_week == 7) {
            $no_remaining_days--;

            if ($the_last_day_of_week == 6) {
                $no_remaining_days--;
            }
        }
        else {
            $no_remaining_days -= 2;
        }
    }

$workingDays = $no_full_weeks * 5;
    if ($no_remaining_days > 0 )
    {
    $workingDays += $no_remaining_days;
    }

    foreach($holidays as $holiday){
        $time_stamp=strtotime($holiday);
        if ($start <= $time_stamp && $time_stamp <= $end && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
            $workingDays--;
    }

    return $workingDays;
}

function listHolidayPeriod($fromDate, $toDate){
    $period = CarbonPeriod::create($fromDate, $toDate);
        
    // Iterate over the period
    foreach ($period as $date) {
        return $date->format('Y-m-d');
    }

    // Convert the period to an array of dates
    $dates = $period->toArray();

    return $dates;
}