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

$cats_ids = [];

if ($result) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $cats_ids = array_column($categories, 'id');
} else {
    $error = mysqli_error($con);
    echo $error;
}


// вставляет контент=форму

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
            return validateFilled('lot_title');
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
            return is_date_valid('date_finish');
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


        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        $file_type = finfo_file($finfo, $tmp_name);


        if (($file_type !== 'image/png') && ($file_type !== 'image/jpeg')) {
            $errors['lot_image'] = 'Картинка должна быть в формате PNG, JPEG или JPG';
        } else {
            move_uploaded_file($tmp_name, 'uploads/' . $filename);
            $lot['path'] = $filename;
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
        echo '<pre>';
        var_dump($errors);
        echo '</pre>';
    } else {
        header("Location: add.php");
    }
} //в случае если данные пришли не из формы, а просто переход по ссылке
else {
    $page_content = include_template('_add-lot.php', [
        'categories' => $categories
    ]);
}


$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
]);

print($layout_content);