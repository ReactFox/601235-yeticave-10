<?php

error_reporting(-1);
require_once 'config/init.php';
require_once 'data/data.php';
require_once 'func/functions.php';
require_once 'helpers.php';

$sql = 'SELECT category_title, symbolic_code FROM categories';

$result = mysqli_query($con, $sql);

if ($result) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($con);
    echo $error;
}

if (isset($_SESSION['user'])) {

    $sql = "SELECT lot_id, lot_image, l.id, lot_title, author_id, contacts, winner_id,
       category_title, date_finish, MAX(bet_amouth) AS max_my_bet, MAX(date_bet) AS date_bate FROM bets b
       JOIN lots l ON b.lot_id = l.id
       JOIN categories c ON l.category_id = c.id
       JOIN users u ON u.id = l.author_id
       WHERE user_id = {$_SESSION['user']['id']}
       GROUP BY lot_id";

    $result = mysqli_query($con, $sql);
    if ($result) {
        $my_bets = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($con);
        echo $error;
    }

    $page_content = include_template('_my-bets.php', [
        'categories' => $categories,
        'my_bets' => $my_bets
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