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

$sql = "SELECT category_title, symbolic_code FROM categories";

$result = mysqli_query($con, $sql);

if ($result) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($con);
    echo $error;
}

//TODO написать нормальный SQl запрос на получение моих лотов
$sql = "SELECT * FROM bets";
$result = mysqli_query($con, $sql);

if ($result) {
    $my_bets = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($con);
    echo $error;
}












if (isset($_SESSION['user'])) {
    $page_content = include_template('_my-bets.php', [
        'categories' => $categories,
//    'lot' => $lot,
//    'sum_bet' => $sum_bet,
//    'history_users_bet' => $history_users_bet
    ]);
} else {
    http_response_code(403);
    header('Location: /login.php');
    exit();
}


$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Мои ставки',
]);

print($layout_content);