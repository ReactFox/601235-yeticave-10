<?php
function amount_formatting($bet)
{
    $bet = ceil($bet);
    $currency_sign = '<b class="rub">р</b>';
    $result = '';

    if ($bet > 0 && $bet < 1000) {
        $result = $bet;
    }
    if ($bet >= 1000) {
        $result = number_format($bet, 0, '', ' ');
    }
    return $result . $currency_sign;
}


function stop_time($final_date)
{
    $time = '';
    $date_now = date_create('now');
    $date_bate = date_create($final_date);
    $date_diff = date_diff($date_bate, $date_now);
    $hour = date_interval_format($date_diff, '%d %H %I');

    $time = explode(' ', $hour);
    $days_left = $time[0];


    if ($days_left > 0) {
        $time[1] = ($days_left * 24) + $time[1];
    }
    return $time;
}