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

function getItem(mysqli $con, $id): array{
    $sql = "SELECT i.name, start_price, img_path, c.name category_name FROM item i JOIN category c on c.id = i.category_id WHERE i.id = ".$id;
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

function xss_protection($string): string{
    return htmlspecialchars($string);
}

$categories_arr = getCategories($con);

$item = getItem($con, $id);

$page_content = include_template('item.php', [ 'item_name' => $item['name'], 'img_path' => $item['img_path'],
    'category_name' => $item['category_name'], 'price' => $item['start_price']]);

$layout_content = include_template('layout.php', ['is_auth' => $is_auth, 'user_name' => $user_name, 'categories_arr' => $categories_arr, 'content' => $page_content ,'title' => $item['name']]);

print($layout_content);
