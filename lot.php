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

// Получает лот и его описание отладочная

if (isset($_GET['id'])) {
    $current_id = $_GET['id'];
}
echo $current_id; // выводит глобальный id правильно ОТЛАДОЧНАЯ ЗАПИСЬ

$sql = "SELECT l.id, lot_title, lot_description, lot_image, category_title FROM lots l JOIN categories c ON l.category_id = c.id
WHERE l.id = {$current_id}"; // выводит лот не правильно

$result = mysqli_query($con, $sql);

if ($result) {
    $lot = mysqli_fetch_all($result, MYSQLI_ASSOC);

} else {
    $error = mysqli_error($con);
    echo $error;
}




$page_content = include_template('lot.php', [
    'categories' => $categories,
//    'lot' => $lot
]);


$layout_content = include_template('layout.php', [

    'content' => $page_content,
    'categories' => $categories,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
]);

print($layout_content);

//выводит данные о лоте отладочная запись
echo '<pre>';
print_r($lot);
echo '</pre>';