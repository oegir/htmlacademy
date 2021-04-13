<?php
require_once('helpers.php');
require_once('db_connection.php');
require_once('service_functions.php');

$is_auth = rand(0,1);
$user_name = 'Artem2J';

if(!isset($_GET['id'])){
    header('Location: pages/404.html');
    die();
}

$id = (int)$_GET['id'];
$categories_arr =[];

$con = db_connect();

function checkId( mysqli $con, $id){
    $sql = "SELECT id FROM item WHERE id = ?";
    $stmt = db_get_prepare_stmt($con, $sql, [$id]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($res) == 0){
        header('Location: pages/404.html');
    }
}

checkId($con, $id);

function getItem(mysqli $con, $id): array{
    $sql = "SELECT i.name, img_path, c.name category_name,description, completion_date, IFNULL(b.price,start_price) current_price,
                IFNULL(b.price + i.bid_step, start_price) min_bid
            FROM item i
            LEFT JOIN category c on c.id = i.category_id
            LEFT JOIN (SELECT
                item_id, MAX(price) price
            FROM bid b2
            GROUP BY item_id) b ON i.id = b.item_id
            WHERE i.id = ?";
    $item = [];
    $stmt = db_get_prepare_stmt($con, $sql, [$id]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res && $row = $res->fetch_assoc()){
        $item = $row;
    }
    return $item;
}

$categories_arr = getCategories($con);

$item = getItem($con, $id);

$page_content = include_template('item.php', [ 'categories_arr' => $categories_arr, 'item_name' => $item['name'], 'img_path' => $item['img_path'],
    'category_name' => $item['category_name'], 'description' => $item['description'],
    'completion_date' => $item['completion_date'], 'current_price' => $item['current_price'],
    'min_bid' => $item['min_bid']]);

$layout_content = include_template('layout.php', ['is_auth' => $is_auth, 'user_name' => $user_name, 'categories_arr' => $categories_arr, 'content' => $page_content ,'title' => $item['name']]);

print($layout_content);
