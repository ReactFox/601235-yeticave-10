<?php
error_reporting(-1);
require_once 'config/init.php';
require_once 'data/data.php';
require_once 'func/functions.php';
require_once 'helpers.php';
require_once 'getwinner.php';

$sql = 'SELECT * FROM categories';

$categories = getCategory($con, $sql);

$sql = 'SELECT MAX(bet_amouth) AS max_bet, date_creation, COUNT(bet_amouth) AS count_bet, 
        l.id, lot_title, lot_image, starting_price, category_title, date_finish FROM lots l
        JOIN categories c ON l.category_id = c.id
        LEFT JOIN bets b ON l.id = b.lot_id
        WHERE date_finish > NOW()
        GROUP BY l.id
        ORDER BY date_creation DESC
        LIMIT 9';

$result = mysqli_query($con, $sql);

if ($result) {
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($con);
    echo $error;
}

mysqli_close($con);

$page_content = include_template('main.php', [
    'categories' => $categories,
    'lots' => $lots,
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Главная страница',
]);

print($layout_content);
    