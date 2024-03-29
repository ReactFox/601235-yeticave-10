<?php
error_reporting(-1);
require_once 'config/init.php';
require_once 'data/data.php';
require_once 'func/functions.php';
require_once 'helpers.php';

$sql = 'SELECT * FROM categories';
$categories = getCategory($con, $sql);

$cats_ids = [];

if ($categories) {
    $cats_ids = array_column($categories, 'id');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lot = $_POST;
    $required = [
        'lot_title',
        'lot_description',
        'starting_price',
        'date_finish',
        'bet_step',
        'category_id'
    ];
    $errors = [];

    $rules = [
        'lot_title' => function () {
            return validateText('lot_title', 1, 64);
        },

        'lot_description' => function () {
            return validateText('lot_description', 1, 128);
        },

        'starting_price' => function () {
            return validatePrice('starting_price');
        },

        'category_id' => function () use ($cats_ids) {
            return validateCategory('category_id', $cats_ids);
        },

        'bet_step' => function () {
            return validatePrice('bet_step');
        },

        'date_finish' => function () {
            return validateTimeFormat('date_finish');
        }
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

    if (!empty($_FILES['lot_image']['name'])) {
        $tmp_name = $_FILES['lot_image']['tmp_name'];
        $path = $_FILES['lot_image']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $filename = uniqid('', true) . ".$ext";
        $file_type = mime_content_type($tmp_name);

        if (($file_type !== 'image/png') && ($file_type !== 'image/jpeg')) {
            $errors['lot_image'] = 'Картинка должна быть в формате PNG, JPEG или JPG';
        } else {
            move_uploaded_file($tmp_name, 'uploads/' . $filename);
            $lot['lot_image'] = $filename;
        }

    } else {
        $errors['lot_image'] = 'Вы не загрузили фото';
    }

    $errors = array_filter($errors);

    if (count($errors)) {
        $page_content = include_template('_add-lot.php', [
            'lot' => $lot,
            'errors' => $errors,
            'categories' => $categories
        ]);

    } else {
        $lot['author_id'] = $_SESSION['user']['id'];
        $sql = 'INSERT INTO lots (date_creation,lot_title,  category_id, lot_description, starting_price, bet_step, date_finish,
                  lot_image, 
                    author_id ) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)';

        $stmt = db_get_prepare_stmt($con, $sql, $lot);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            $lot_id = mysqli_insert_id($con);

            header('Location:lot.php?id=' . $lot_id);
        }
    }
} else {
    $page_content = include_template('_add-lot.php', [
        'categories' => $categories
    ]);
    if (!isset($_SESSION['user'])) {
        http_response_code(403);
        header('Location: /register.php');
        exit();
    }
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Добавить лот',
]);

print($layout_content);