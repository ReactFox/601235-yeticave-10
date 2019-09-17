<?php
require_once 'config/init.php';
require_once 'data/data.php';
require_once 'func/functions.php';
require_once 'helpers.php';

if (!$con) {
    $error = mysqli_connect_error();
    exit($error);
}

$sql = "SELECT * FROM categories";
$result = mysqli_query($con, $sql);

if ($result) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $error = mysqli_error($con);
    echo $error;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $search = $_GET['search'] ?? '';
    $search = trim($search);

    if (isset($search)) {
        //кол-во лотов на странице в выдаче
        $page_items = 9;
//        print_r($page_items);
//
        $cur_page = $_GET['page'] ?? $_GET['page'] = 1;
//        print_r($cur_page);
        $sql = "SELECT COUNT(l.id) AS cnt
                FROM lots l JOIN categories c ON l.category_id = c.id
                WHERE MATCH(lot_title, lot_description) AGAINST(?) AND date_finish > NOW()";
//
        $stmt = db_get_prepare_stmt($con, $sql, [$search]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $items_count = mysqli_fetch_assoc($result)['cnt'];
        echo 'кол-во найденых элементов: ';
        print_r($items_count);
        echo '<br>';

        $pages_count = ceil($items_count / $page_items);
        $offset = ($cur_page - 1) * $page_items;
        $pages = range(1, $pages_count);

        echo 'кол-во страниц ';
        print_r(count($pages));
        echo '<br>';


        $sql = "SELECT MAX(bet_amouth) AS max_bet, COUNT(bet_amouth) AS count_bet, l.id,
                date_creation, lot_title, lot_image, starting_price, category_title, date_finish
                FROM lots l JOIN categories c ON l.category_id = c.id
                LEFT JOIN bets b ON l.id = b.lot_id WHERE MATCH(lot_title, lot_description) AGAINST(?)
                AND date_finish > NOW() GROUP BY l.id
                ORDER BY date_creation DESC LIMIT {$page_items} OFFSET {$offset}";

        $stmt = db_get_prepare_stmt($con, $sql, [$search]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if (mysqli_num_rows($result) === 0) {
            $search = 'Ничего не найдено по вашему запросу';
        }

        $page_content = include_template('_search.php', [
            'categories' => $categories,
            'lots' => $lots,
            'search' => $search
        ]);

    } else {
        $page_content = include_template('_search.php', [
            'categories' => $categories,
        ]);
    }

} else {
    $page_content = include_template('_search.php', [
        'categories' => $categories
    ]);
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Результаты поиска'
]);

print($layout_content);