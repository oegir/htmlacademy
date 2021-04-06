<?php
require_once('helpers.php');
require_once('db_connection.php');
require_once('service_functions.php');

$is_auth = rand(0, 1);

$categories_arr = [];
$items_arr = [];

$con = db_connect();

function getCategories(mysqli $con): array{
    $sql = "SELECT name, code FROM category";
    $categories = [];
    $res = mysqli_query($con, $sql);
    while ($res && $row = $res->fetch_assoc()){
        $categories[] = $row;
    }
    return $categories;
}

$categories_arr = getCategories($con);

function getItems (mysqli $con): array{
    $sql = "SELECT
                i.id id, i.name, c.name category, IFNULL(b.price,start_price) price, img_path url, completion_date expiry_date
             FROM  item i
            LEFT JOIN category c on c.id = i.category_id
            LEFT JOIN
                (SELECT
                    item_id, MAX(price) price
                FROM bid b2
                GROUP BY item_id) b ON i.id = b.item_id
            WHERE i.winner_id IS NULL
            ORDER BY date DESC";
    $items = [];
    $res = mysqli_query($con, $sql);
    while ($res && $row = $res->fetch_assoc()){
        $items[] = $row;
    }
    return $items;
}

$items_arr = getItems($con);

$user_name = 'Artem2J'; // укажите здесь ваше имя

$page_content = include_template('main.php', [ 'items_arr' => $items_arr, 'categories_arr' => $categories_arr]);

$layout_content = include_template('layout.php', ['is_auth' => $is_auth, 'user_name' => $user_name, 'categories_arr' => $categories_arr, 'content' => $page_content ,'title' => 'Главная']);

print($layout_content);
