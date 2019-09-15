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

$current_page = key($_GET) ?? '';
$current_page = mysqli_real_escape_string($con, $current_page);

$sql = "SELECT l.id, symbolic_code, lot_title, lot_image, starting_price, category_title, date_finish
FROM lots l
         JOIN categories c ON l.category_id = c.id
WHERE date_finish > NOW() AND symbolic_code = '{$current_page}'
ORDER BY date_creation DESC LIMIT 9";

$result = mysqli_query($con, $sql);

if ($result) {
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($con);
    echo $error;
}

$sql = "SELECT symbolic_code, category_title
FROM categories
WHERE symbolic_code = '{$current_page}'
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
    'current_category' => $current_category
]);


$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Все лоты категории: ' . $current_category['category_title'],
]);

print($layout_content);