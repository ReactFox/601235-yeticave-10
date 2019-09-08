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

if ($result) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $cats_ids = array_column($categories, 'id');
} else {
    $error = mysqli_error($con);
    echo $error;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST;
    $required = [
        'email',
        'password',
    ];
    $errors = [];
    foreach ($required as $key) {
        if (!isset($_POST[$key]) || (trim($_POST[$key]) === '')) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    $email = mysqli_real_escape_string($con, $form['email']);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($con, $sql);

    if (mysqli_num_rows($res) === 0) {
        $errors['email'] = 'Пользователя с таким Email не существует проверьте правильность написания Email';
    }

    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

    if (!count($errors) && $user) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    }

    $errors = array_filter($errors);

    if (count($errors)) {
        $page_content = include_template('_login.php', [
            'form' => $form,
            'errors' => $errors,
            'categories' => $categories
        ]);
    } else {
        header('Location: /index.php');
        exit();
    }

} else {
    $page_content = include_template('_login.php', [
        'categories' => $categories
    ]);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Вход',
]);

print($layout_content);