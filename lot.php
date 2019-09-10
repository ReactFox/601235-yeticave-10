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

$sql = "SELECT l.id, lot_title, lot_description, lot_image, bet_step, date_finish, category_title, starting_price FROM lots l JOIN categories c ON l.category_id = c.id
WHERE l.id = {$current_id}";

$result = mysqli_query($con, $sql);

if ($result) {
    $lot = mysqli_fetch_assoc($result);
// если пользователь залогинен
    if(isset($_SESSION['user'])) {
//    Получает текущую цену лота
        $sql = "SELECT SUM(bet_amouth) AS sum_bet FROM bets WHERE lot_id = {$current_id}";
        $result_bet = mysqli_query($con, $sql);
        if ($result_bet) {
            $sum_bet = mysqli_fetch_assoc($result_bet);
            if ($sum_bet !== true){
                $sum_bet['sum_bet'] = $lot['starting_price'];
            }
        }
        else {
            $error = mysqli_error($con);
            echo $error;
        }

//        если получил форма ставки была отправленна по форме
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bet = $_POST;
//            var_dump($bet);
            $required = [
                'cost'
            ];

            $errors = [];
//            $rules = [
//                'cost' => function () {
//                    return validatePrice('cost');
//                },
//            ];

//            foreach ($_POST as $key => $value) {
//                if (isset($rules[$key])) {
//                    $rule = $rules[$key];
//                    $errors[$key] = $rule();
//                }
//            }

            foreach ($required as $key) {
                if (!isset($_POST[$key]) || (trim($_POST[$key]) === '')) {
                    $errors[$key] = 'Это поле надо заполнить';
                }
            }

            var_dump($errors);            








        }
    }


    $page_content = include_template('_lot.php', [
        'categories' => $categories,
        'lot' => $lot,
        'sum_bet' => $sum_bet
    ]);


    if (!mysqli_num_rows($result)) {
        http_response_code(404);
        $page_content = include_template('_404.php', [
            'categories' => $categories
        ]);
    }

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
