<?php
error_reporting(-1);
require_once 'config/init.php';
require_once 'data/data.php';
require_once 'func/functions.php';
require_once 'helpers.php';


if (!$con) {
    $error = mysqli_connect_error();
    echo $error;
    exit;
}

//получает категории
$sql = "SELECT category_title, symbolic_code FROM categories";

$result = mysqli_query($con, $sql);

if ($result) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($con);
    echo $error;
}

$current_id = null;
if (isset($_GET['id'])) {
    $current_id = (int)$_GET['id'];
}

$sql = "SELECT l.id, author_id, lot_title, lot_description, lot_image, bet_step, date_finish, category_title, starting_price FROM lots l JOIN categories c ON l.category_id = c.id
WHERE l.id = {$current_id}";

$result = mysqli_query($con, $sql);

if ($result) {
    $lot = mysqli_fetch_assoc($result);
    //получаем цену лота
    $sql = "SELECT SUM(bet_amouth) AS sum_bet, COUNT(id) AS total_bet FROM bets WHERE lot_id = {$current_id}";
    $result_bet = mysqli_query($con, $sql);
    if ($result_bet) {
        $sum_bet = mysqli_fetch_assoc($result_bet);
        if (!empty($sum_bet['sum_bet'])) {
            $sum_bet['sum_bet'] += $lot['starting_price'];
        } else {
            $sum_bet['sum_bet'] = $lot['starting_price'];
        }
    } else {
        $error = mysqli_error($con);
        echo $error;
    }

//    Получаем Историю ставок
    $sql = "SELECT user_name, bet_amouth, date_bet FROM bets JOIN users u ON bets.user_id = u.id
            WHERE lot_id = {$current_id} ORDER BY date_bet DESC";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $history_users_bet = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($con);
        echo $error;
    }

// если пользователь залогинен
    if (isset($_SESSION['user'])) {
//        $find_user_bet = isset ($history_users_bet[0]['user_name']) ? $history_users_bet[0]['user_name'] : '';

        // если получил форма ставки была отправленна по форме
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
//            $bet = [];
//            $bet = $_POST['cost'];
//            var_dump($bet);
            $min_bet = $lot['bet_step'];
            $required = [
                'cost'
            ];

            $rules = [
                'cost' => function () use ($min_bet) {
                    return check_sum_bet('cost', $min_bet);
                }
            ];

            foreach ($_POST as $key => $value) {
                if (isset($rules[$key])) {
                    $rule = $rules[$key];
                    $errors[$key] = $rule();
                }
            }

            foreach ($required as $key) {
                if (!isset($_POST[$key]) || (trim($_POST[$key]) === '')) {
                    $errors[$key] = 'Это поле надо заполнить';
                }
            }

            $errors = array_filter($errors);

            if (count($errors)) {
                $page_content = include_template('_lot.php', [
                    'lot' => $lot,
                    'categories' => $categories,
                    'sum_bet' => $sum_bet,
                    'errors' => $errors,
                    'history_users_bet' => $history_users_bet,
                    'find_user_bet' => $find_user_bet
                ]);
            } else {
                $bet['bet_amouth'] = $_POST['cost'];
                $bet['user_id'] = $_SESSION['user']['id'];
                $bet['lot_id'] = $lot['id'];

                $sql = 'INSERT INTO bets (date_bet, bet_amouth,  user_id, lot_id)
                        VALUES (NOW(), ?, ?, ?)';

                $stmt = db_get_prepare_stmt($con, $sql, $bet);
                $res = mysqli_stmt_execute($stmt);

                if ($res) {
                    $lot_id = $lot['id'];

                    header('Location:lot.php?id=' . $lot_id);
                }

            }

        } //Конец отправленой формы

        else {
            $page_content = include_template('_lot.php', [
                'categories' => $categories,
                'lot' => $lot,
                'sum_bet' => $sum_bet,
                'history_users_bet' => $history_users_bet,
//                'find_user_bet' => $find_user_bet
            ]);
        }
    } // Конец сессии
    else {
//     Показ текущей суммы и контента для неавтраизованного пользователя
        $page_content = include_template('_lot.php', [
            'categories' => $categories,
            'lot' => $lot,
            'sum_bet' => $sum_bet,
            'history_users_bet' => $history_users_bet
        ]);
    }

//    if (!mysqli_num_rows($result)) {
//        http_response_code(404);
//        $page_content = include_template('_404.php', [
//            'categories' => $categories
//        ]);
//    }

} else {
    $error = mysqli_error($con);
    echo $error;
    exit();
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Лот: ' . $lot['lot_title'],
]);

print($layout_content);
