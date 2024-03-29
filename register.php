<?php

error_reporting(-1);
require_once 'config/init.php';
require_once 'data/data.php';
require_once 'func/functions.php';
require_once 'helpers.php';

$sql = 'SELECT * FROM categories';
$categories = getCategory($con, $sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST;
    $required = [
        'email',
        'user_name',
        'password',
        'contacts',
    ];

    $errors = [];

    $rules = [
        'email' => function () {
            return validateEmail('email', 4, 24);
        },
        'user_name' => function () {
            return validateText('user_name', 4, 24);
        },
        'password' => function () {
            return validateText('password', 4, 64);
        },
        'contacts' => function () {
            return validateText('contacts', 4, 255);
        },
    ];

    foreach ($_POST as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule();
        }
    }

    foreach ($required as $key) {
        if (!isset($_POST[$key]) || (trim($_POST[$key]) === '')) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    $email = mysqli_real_escape_string($con, $form['email']);
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $res = mysqli_query($con, $sql);
    if (mysqli_num_rows($res) > 0) {
        $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
    }

    $errors = array_filter($errors);

    if (count($errors)) {
        $page_content = include_template('_reg.php', [
            'form' => $form,
            'errors' => $errors,
            'categories' => $categories
        ]);
    }elseif ($res && empty($errors)) {
        $form['password'] = password_hash($form['password'], PASSWORD_DEFAULT);
        $sql = 'INSERT INTO users (date_registration, email, password, user_name, contacts) VALUES (NOW(), ?, ?, ?, ?)';
        $stmt = db_get_prepare_stmt($con, $sql, $form);
        $res = mysqli_stmt_execute($stmt);

        header('Location: /login.php');
        exit();
    }
} else {
    $page_content = include_template('_reg.php', [
        'categories' => $categories,
    ]);
    if (isset($_SESSION['user'])) {
        http_response_code(403);
        header('Location: /index.php');
        exit();
    }
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Регистрация пользователя',
]);

print($layout_content);