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

function getPostVal($name)
{
    return $_POST[$name] ?? '';
}

function validateFilled($name)
{
    if (empty($_POST['$name'])) {
        return 'err_field';
    } else {
        return '';
    }
}

function validatePrice($name)
{
    if (empty($_POST['$name'])) {
        return 'err_field';
    } else {
        return '';
    }
    return $resalt;
}


//function validateCategory($name, $allowed_list) {
//    $id = $_POST[$name];
//
//    $errors[] = '';
//    if (!in_array($id, $allowed_list)) {
//        return $errors['lot_category'];
//    }
//
//    return null;
//}
//
//function validateLength($name, $min, $max)
//{
//    $len = strlen($_POST[$name]);
//
//    if ($len < $min or $len > $max) {
//        return "Значение должно быть от $min до $max символов";
//    }
//
//    return null;
//}