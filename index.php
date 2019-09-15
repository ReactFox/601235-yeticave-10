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

//получает список лотов на главной
$sql = "SELECT l.id, lot_title, lot_image, starting_price, category_title, date_finish
FROM lots l
         JOIN categories c ON l.category_id = c.id
WHERE date_finish > NOW()
ORDER BY date_creation DESC LIMIT 9";

$result = mysqli_query($con, $sql);

if ($result) {
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($con);
    echo $error;
}

$sql = "SELECT l.id, COUNT(lot_id) AS bet_amouth, SUM(bet_amouth) AS sum_bet FROM lots l
        JOIN bets b ON b.lot_id = l.id GROUP BY l.id";
$result_bet = mysqli_query($con, $sql);
if ($result_bet) {
    $sum_bets = mysqli_fetch_all($result_bet, MYSQLI_ASSOC);
    foreach ($sum_bets as $sum_bet) {
        echo '<pre>';
        $current_sum_bet = $sum_bet['sum_bet'] ?? '';
        $bet_amouth = $sum_bet['bet_amouth'] ?? '';
        print_r($sum_bet);
        echo '</pre>';
//        if (!empty($sum_bet['sum_bet'])) {
//            $sum_bet['sum_bet'];
//        } else {
//            $sum_bet['sum_bet'] = $sum_bet['starting_price'];
//        }
    }
} else {
    $error = mysqli_error($con);
    echo $error;
}


mysqli_close($con);

$page_content = include_template('main.php', [
    'categories' => $categories,
    'lots' => $lots,
    'current_sum_bet' => $current_sum_bet,
    'bet_amouth' => $bet_amouth
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Главная страница',
]);

print($layout_content);
