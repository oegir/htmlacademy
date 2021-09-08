<?php
require_once('sess.php');
require_once('helpers.php');
require_once('db_connection.php');
require_once('service_functions.php');

if(!isset($_GET['id'])){
    header('Location: pages/404.html');
    die();
}

$id = (int)$_GET['id'];
$categories_arr =[];

$con = db_connect();

$user_name = getUserNameById($con, sess_get_user_id());


checkId($con, $id);

$categories_arr = getCategories($con);

$item = getItem($con, $id);

$page_content = include_template('item.php', ['user_name' => $user_name, 'categories_arr' => $categories_arr, 'item_name' => $item['name'], 'img_path' => $item['img_path'],
    'category_name' => $item['category_name'], 'description' => $item['description'],
    'completion_date' => $item['completion_date'], 'current_price' => $item['current_price'],
    'min_bid' => $item['min_bid']]);

$layout_content = include_template('layout.php', ['user_name' => $user_name, 'categories_arr' => $categories_arr, 'content' => $page_content ,'title' => $item['name']]);

print($layout_content);

/**
 * Проверяет наличие лота с заданным id. В случае отсутствия перенаправляет на страницу 404
 *
 * @param  mysqli $con Подключение к БД.
 * @param  int $id id лота.
 * @return void 
 */
function checkId( mysqli $con, int $id){
    $sql = "SELECT id FROM item WHERE id = ?";
    $stmt = db_get_prepare_stmt($con, $sql, [$id]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($res) == 0){
        header('Location: pages/404.html');
    }
}

/**
 * Возвращает лот по id.
 *
 * @param  mysqli $con Подключение к БД.
 * @param  mixed $id id лота.
 * @return array Массив с данными лота.
 */
function getItem(mysqli $con, int $id): array{
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