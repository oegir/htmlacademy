<?php
require_once('helpers.php');

$is_auth = rand(0, 1);

$categories_arr = [];
$items_arr = [];

$con = mysqli_connect('localhost', 'root', 'root', 'yeticave');
if ($con == false){
    print ("Ошибка подключения" . mysqli_connect_error());
    die();
}
mysqli_set_charset($con, "utf8");

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
                i.name, c.name category, IFNULL(b.price,start_price) price, img_path url, completion_date expiry_date
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

//Включение фильтра для защиты от XSS
function xss_protection($string): string{
    return htmlspecialchars($string);
}


function price_format($price): string{
    return number_format(ceil($price),0, '.',' ').' ₽';
}

function get_dt_range($date): array{
    date_default_timezone_set('Europe/Moscow');
    $expiry_date = DateTime::createFromFormat('Y-m-d', $date);
    $expiry_date->setTime(23, 59, 59);
    $currentDate = new DateTime();
    $dt_range = $currentDate->diff($expiry_date);

    $hours = 0;
    $minutes = 0;

    if (! $dt_range->invert) {
        $hours = $dt_range->days * 24 + $dt_range->h;
        $minutes = $dt_range->i;
    }

    $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
    $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);

    return [$hours, $minutes];
}

$page_content = include_template('main.php', [ 'items_arr' => $items_arr, 'categories_arr' => $categories_arr]);

$layout_content = include_template('layout.php', ['is_auth' => $is_auth, 'user_name' => $user_name, 'categories_arr' => $categories_arr, 'content' => $page_content ,'title' => 'Главная']);

print($layout_content);
