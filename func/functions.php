<?php

/**
 * Форматирует отображение цены в зависимости от суммы, а также от в случае надобности при передаче вторым
 * параметром будет добавлен знак Рубля
 *
 * @param int $bet Цена которую надо отформатировать
 * @param int $need_sign Знак Рубля после цены, если нет необходимости добавить то нужно передать в качестве аргумента 0
 * @return float|string возвращается отформатированная цена
 */
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

/**
 * Возращает оставшиеся время до окончания ставки в нужом формате 'ЧЧ ММ'
 *
 * @param string $final_date дата окончания приёма ставок
 * @return array|string дата в формате 'ЧЧ' 'ММ'
 */
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

/**
 * Устанвливает значение для полей формы по умолчанию если он были корректны при отправке
 * В случае если остальные данные в форме были не верны, то правильно заполненные данные
 * остануться заполненными и их не прийдётся вводить заново
 *  *
 * @param mixed|string $name
 * @return mixed|string
 */
function getPostVal($name)
{
    return $_POST[$name] ?? '';
}

/**
 * Функция проверяет корретность длинны вводимых данных в поле формы
 * в зависимости от необходимого размера символов, в случае ошибки
 * вернёт текст ошибки с указанием требований к вводимому тексту.
 *
 * @param string $name ключ элемента массива над которым необходимо произвести проверку
 * @param int $min минимальная длинна текста
 * @param int $max максимальная длинна текста
 * @return string в случае ложной проверки вернёт сообщение об ошибку которую надо исправить
 */
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

/**
 * Возращает результат проверки цены на целое число, число меншье нуля, а также проверки что вводимые данные
 * имеют числовой тип
 *
 * @param string $name ключ массива над которым нужно произвести проверку
 * @return bool|string в случае ошибки вёрнёт текст ошибки в зависимости от вида ошибки
 */
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

/**
 * Проверяет условие, чтобы дата размещения была на 24 больше размещения ставок
 * Возращает ошибку если число не соотвествует формату ГГГГ-ММ-ДД
 *
 * @param string $date ключ масива даты окончания ставок
 * @return string содержание ошибки валидации даты размещения лота
 */
function validateTimeFormat($date)
{
    $date_now = time();
    $date_bate = strtotime($_POST[$date]);
    $date_diff = $date_bate - $date_now;
    $result = '';

    if (is_date_valid($date)) {
        $result = 'Введите число в формате ГГГГ-ММ-ДД';
    } elseif ($date_diff < 86400) {
        $result = 'Дата окончания торгов не может быть раньше через чем 24 часа';
    }

    return $result;
}

/**
 * Проверяте обязательность выбора категории лота
 *
 * @param string $name ключ массива значение которого необходимо проверить
 * @param array $allowed_list ключи массива категорий ставок
 * @return string|null в случае ошибки вёрнёт её текст
 */
function validateCategory($name, $allowed_list)
{
    $result = null;
    $id = $_POST[$name];

    if (!in_array($id, $allowed_list)) {
        $result = 'Выберите категорию';
    }

    return $result;
}

/**
 * Возвращает результат проверки поля e-mail на соответсвие заданным требованиям.
 *
 * @param string $email ключ массива значение которого необходимо проверить
 * @param int $min минимальное число символов в поле
 * @param int $max максимальное число символов в поле
 * @return bool|string в случае ошибки вернёт текст ошибки
 */
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

/**
 * Проверят сумму ставки которую вводит участник аукциона.
 * В случае если ставка не целое число или ставка меньше текущей цены вернёт текст ошибки
 *
 * @param string $check_bet ключ массива указывающий на текущую ставку
 * @param int $min_bet сумма текущей ставки введённой пользователем
 * @return bool|string вернёт текст в случае ошибки
 */
function check_sum_bet($check_bet, $min_bet)
{
    $result = false;
    $post_data = $_POST[$check_bet];

    if ((!is_numeric($post_data) || (strpos($post_data, '.') !== false))) {
        $result = 'Введите целое число';
    } elseif ($_POST[$check_bet] < $min_bet) {
        $result = 'Ставка должна большье текущей цены с учётом размера мин. ставки';
    }

    return $result;
}

/**
 * Приводит дату размещения ставки в человека читаеммый формат
 *
 * @param string $date_pub ключ массива указывающий на дату размещения ставки
 * @return string возращает отформатированную строку
 */
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

/**
 * создаёт рекомедованную цену в placeholder ставки
 *
 * @param string $sum_bet размер ставки
 * @param string $lot_step размер шага ставки
 * @return mixed возвращает рекомендованную цену
 */
function placeholder_format($sum_bet, $lot_step)
{
    return $sum_bet + $lot_step;
}

/**
 * Возращает в виде CSS класса статус сделанной ставки елси аукцион по лоту завершился
 * или ставка выигрыла
 *
 * @param string $date_finish дата окончания ставки
 * @param int $winner_id выигрывший пользователь(его ID)
 * @return string возращает CSS класс
 */
function get_status_user_bet($date_finish, $winner_id)
{
    $result = '';
    if ((strtotime($date_finish) < time()) && ($winner_id === null)) {
        $result = 'rates__item--end';
    } elseif ((strtotime($date_finish) < time()) && ($winner_id === $_SESSION['user']['id'])) {
        $result = 'rates__item--win';
    }
    return $result;
}

/**
 * Получает список категорий
 *
 * @param resource $con получает ресурс соеденения
 * @param string $sql получает sql запрос для выполнения
 * @return array|string|null возращает ассоциативный массив в случае успешного
 * получения данных, инначе вернёт ошибку
 */
function getCategory($con, $sql)
{
    $result = '';
    $res = mysqli_query($con, $sql);
    if ($res) {
        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    } else {
        $result = mysqli_error($con);
    }
    return $result;
}