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

$sql = 'SELECT category_title, symbolic_code FROM categories';
$result = mysqli_query($con, $sql);

if ($result) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($con);
    echo $error;
}

$current_page_category = key($_GET) ?? '';
$current_page_category = mysqli_real_escape_string($con, $current_page_category);

$page_items = 9;

$cur_page = $_GET['page'] ?? $_GET['page'] = 1;

$sql = "SELECT COUNT(l.id) AS cnt FROM lots l
         JOIN categories c ON l.category_id = c.id
WHERE symbolic_code = '{$current_page_category}' ";

$result = mysqli_query($con, $sql);
$items_count = '';
if ($result) {
    $items_count = mysqli_fetch_assoc($result)['cnt'];
} else {
    $error = mysqli_error($con);
    echo $error;
}

$pages_count = ceil($items_count / $page_items);
$offset = ($cur_page - 1) * $page_items;
$pages = range(1, $pages_count);

$sql = "SELECT MAX(bet_amouth) AS max_bet, date_creation, COUNT(bet_amouth) AS count_bet, l.id, lot_title, lot_image, starting_price, category_title, date_finish
FROM lots l
         JOIN categories c ON l.category_id = c.id
         LEFT JOIN bets b ON l.id = b.lot_id
WHERE date_finish > NOW() AND symbolic_code = '{$current_page_category}'
GROUP BY l.id
ORDER BY date_creation DESC
LIMIT {$page_items} OFFSET {$offset}";

$result = mysqli_query($con, $sql);
if ($result) {
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($con);
    echo $error;
}

$sql = "SELECT symbolic_code, category_title
FROM categories
WHERE symbolic_code = '{$current_page_category}'
GROUP BY category_title";

$result = mysqli_query($con, $sql);

if ($result) {
    $current_category = mysqli_fetch_array($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($con);
    echo $error;
}

$page_content = include_template('_all-lots.php', [
    'categories' => $categories,
    'lots' => $lots,
    'current_category' => $current_category,
    'pages_count' => $pages_count,
    'items_count' => $items_count,
    'current_page_category' => $current_page_category,
    'pages' => $pages,
    'cur_page' => $cur_page
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Все лоты категории: ' . $current_category['category_title']
]);

print($layout_content);