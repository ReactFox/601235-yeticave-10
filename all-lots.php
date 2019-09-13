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



$page_content = include_template('_all-lots.php', [
    'categories' => $categories,
]);





$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Все лоты',
]);

print($layout_content);