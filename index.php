<?php
error_reporting(-1);

require_once 'data/data.php';
require_once 'func/functions.php';
require_once 'helpers.php';

$page_content = include_template('main.php', [
    'categories' => $categories,
    'lots' => $lots
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
]);

print($layout_content);

