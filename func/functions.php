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

// валидация заголовка
function validateFilled($name)
{
    $result = '';
    if (empty($_POST[$name])) {
        $result = 'Введите наименование лота';
    }

    return $result;
}

// Валидация описания
function validateText($name, $min, $max)
{
    $result = '';
    $len = mb_strlen($_POST[$name]);

    if ($len < $min || $len > $max) {
        $result = 'Описание лота должно быть от $min до $max символов';
    }

    return $result;
}

//$_POST['starting_price'] = '-1';
//validatePrice('starting_price');

//Валидация цены
function validatePrice($name)
{
    $result = false;
    $post_data = $_POST[$name];

    if (empty($post_data)) {
        $result = 'Укажите начальную цену';
    }
    else {
        $post_data = (int) $post_data;
        if(!is_int($post_data)){
            $result = 'введите целое число';
        }

        if($post_data <= 0){
            $result = 'Цена должна быть больше нуля';
        }
    }
//TODO узнать про валидацию с нулём
    return $result;
}

