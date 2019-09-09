<?php
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
} else {
    $error = mysqli_error($con);
    echo $error;
}

$lots = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $lots = $_GET;
    $search = $_GET['search'] ?? '';
    $search = trim($search);
    print_r($search);


    if ($search) {
        $sql = "SELECT l.id, lot_title, lot_description,lot_image, starting_price, category_title,date_finish
FROM lots l
         JOIN categories c ON l.category_id = c.id
WHERE MATCH(lot_title, lot_description) AGAINST(?)
HAVING date_finish > NOW()
ORDER BY date_creation DESC";

        $stmt = db_get_prepare_stmt($con, $sql, [$search]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

        echo '<br>';
        print_r($lots);
        echo '<br>';
    }
    $page_content = include_template('_search.php', [
        'categories' => $categories
    ]);

}

$page_content = include_template('_search.php', [
    'categories' => $categories
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Результаты поиска'
]);

print($layout_content);