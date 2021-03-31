<?php
require_once('helpers.php');

$is_auth = rand(0,1);
$user_name = 'Artem2J';
$id = $_GET['id'];
$categories_arr =[];
$con = mysqli_connect('localhost', 'root', 'root', 'yeticave');
if ($con == false){
    print ("Ошибка подключения" . mysqli_connect_error());
    die();
}
mysqli_set_charset($con, "utf8");

function checkId( mysqli $con, $id){
    $sql = "SELECT id FROM item WHERE id = ".$id;
    $res = mysqli_query($con, $sql);
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
            WHERE i.id =".$id;
    $item = [];
    $res = mysqli_query($con, $sql);
    if ($res && $row = $res->fetch_assoc()){
        $item = $row;
    }
    return $item;
}
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

$item = getItem($con, $id);

$page_content = include_template('item.php', [ 'item_name' => $item['name'], 'img_path' => $item['img_path'],
    'category_name' => $item['category_name'], 'description' => $item['description'],
    'completion_date' => $item['completion_date'], 'current_price' => $item['current_price'],
    'min_bid' => $item['min_bid']]);

$layout_content = include_template('layout.php', ['is_auth' => $is_auth, 'user_name' => $user_name, 'categories_arr' => $categories_arr, 'content' => $page_content ,'title' => $item['name']]);

print($layout_content);
