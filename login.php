<?php

error_reporting(-1);
require_once 'config/init.php';
require_once 'data/data.php';
require_once 'func/functions.php';
require_once 'helpers.php';

if (!$con) {
    $error = mysqli_connect_error();
    exit($error);
}

//получает категории
$sql = "SELECT * FROM categories";

$result = mysqli_query($con, $sql);

//$cats_ids = [];

if ($result) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $cats_ids = array_column($categories, 'id');
} else {
    $error = mysqli_error($con);
    echo $error;
}

$page_content = include_template('_login.php', [
    'categories' => $categories
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => $title,
//    'is_auth' => $is_auth,
//    'user_name' => $user_name,
]);

print($layout_content);