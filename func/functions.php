<?php
function amount_formatting($bet, $need_sign = 1)
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

    if ($need_sign === 1) {
        $result .= $currency_sign;
    } elseif ($need_sign !== 1) {
        $result;
    }

    return $result;
}


function stop_time($final_date)
{
    $time = '';
    $date_now = date_create('now');
    $date_bate = date_create($final_date);
    $date_diff = date_diff($date_bate, $date_now);
    $hour = date_interval_format($date_diff, '%d %H %I');

//    TODO посоветоваться с наставником насчёт того как победить разницу когда она отрицательная, но выводиться положительная

    $time = explode(' ', $hour);
    $days_left = $time[0];


    if ($days_left > 0) {
        $time[1] = ($days_left * 24) + $time[1];
    }
    return $time;
}

//Устанвливает значение для полей формы если он были корректны при отправке
function getPostVal($name)
{
    return $_POST[$name] ?? '';
}


// Валидация описания текстовых полей на длинну
function validateText($name, $min, $max)
{
    $result = '';
    $len = mb_strlen($_POST[$name]);
    $validate_field = $name;

    if ($len < $min || $len > $max) {
        if ($validate_field === 'lot_title') {
            $field_text_error = 'Наименование лота должно быть от' . $min . 'до' . $max . 'символов';
            $result = $field_text_error;
        }
        if ($validate_field === 'lot_description') {
            $field_text_error = 'Описание лота должно быть от' . $min . 'до' . $max . 'символов';
            $result = $field_text_error;
        }
        if ($validate_field === 'user_name') {
            $field_text_error = 'Имя пользователя быть от' . $min . 'до' . $max . 'символов';
            $result = $field_text_error;
        }
        if ($validate_field === 'password') {
            $field_text_error = 'Длинна пароля должна быть от' . $min . 'до' . $max . 'символов';
            $result = $field_text_error;
        }
        if ($validate_field === 'contacts') {
            $field_text_error = 'Длинна контактных даннных должна быть от ' . $min . 'до' . $max . 'символов';
            $result = $field_text_error;
        }
    }
    return $result;
}

//Валидация цены
function validatePrice($name)
{
    $result = false;
    $post_data = $_POST[$name];

    if ((strpos($post_data, '.') !== false) || (!is_numeric($post_data))) {
        $result = 'Введите целое число';
    } elseif ($post_data <= 0) {
        $result = 'Значение должно быть больше нуля';
    }

    return $result;
}

function validateTimeFormat($date)
{
    $date_now =  time();
    $date_bate = strtotime($_POST[$date]);
    $date_diff = $date_bate - $date_now;
    $result ='';

    if (is_date_valid($date)) {
        $result = 'Введите число в формате ГГГГ-ММ-ДД';
    }

    elseif($date_diff < 86400) {
        $result = 'Дата окончания торгов не может быть раньше через чем 24 часа';
    }

    return $result;
}

function validateCategory($name, $allowed_list)
{
    $result = null;
    $id = $_POST[$name];

    if (!in_array($id, $allowed_list)) {
        $result = 'Выберите категорию';
    }

    return $result;
}

//Валидация email
function validateEmail($email, $min, $max)
{
    $result = false;

    $len = mb_strlen($_POST[$email]);

    if ($len < $min || $len > $max) {
        $result = 'Длинна E-mail должна быть от' . $min . 'до' . $max . 'символов';
    }
    if (!filter_var($_POST[$email], FILTER_VALIDATE_EMAIL)) {
        $result = 'Email должен быть корректным';
    }
    return $result;
}

//Валидация сделанной ставки
function check_sum_bet($check_bet, $min_bet)
{
    $result = false;
    $post_data = $_POST[$check_bet];

    if ((!is_numeric($post_data) || (strpos($post_data, '.') !== false))) {
        $result = 'Введите целое число';
    } elseif ($_POST[$check_bet] < $min_bet) {
        $result = 'Ставка должна быть равна или больше минимальной ставки';
    }

    return $result;
}

//Приводит дату времени размещения ставки в человеческий формат
function get_relative_format($date_pub)
{
    $date_pub = strtotime($date_pub);
    $date_now = time();
    $date_diff = $date_now - $date_pub;
    if ($date_diff < 3600) {
        $params = array(
            'sec' => 60,
            'singular' => ' минута',
            'genitive' => ' минуты',
            'plural' => ' минут'
        );
    } elseif ($date_diff >= 3600 && $date_diff <= 86400) {
        $params = array(
            'sec' => 3600,
            'singular' => ' час',
            'genitive' => ' часа',
            'plural' => ' часов'
        );
    } elseif ($date_diff > 86400 && $date_diff <= 604800) {
        $params = array(
            'sec' => 86400,
            'singular' => ' день',
            'genitive' => ' дня',
            'plural' => ' дней'
        );
    } elseif ($date_diff > 604800 && $date_diff <= 3024000) {
        $params = array(
            'sec' => 604800,
            'singular' => ' неделя',
            'genitive' => ' недели',
            'plural' => ' недель'
        );
    } elseif ($date_diff > 3024000) {
        $params = array(
            'sec' => 3024000,
            'singular' => ' месяц',
            'genitive' => ' месяца',
            'plural' => ' месяцев'
        );
    }
    $date_create = floor($date_diff / $params['sec']);
    $result = $date_create . get_noun_plural_form($date_create, $params['singular'], $params['genitive'],
            $params['plural']) . ' назад';
    return $result;
}