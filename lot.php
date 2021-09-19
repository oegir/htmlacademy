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
$error = null;
$bid = null;

$con = db_connect();

$user_name = getUserNameById($con, sess_get_user_id());


checkId($con, $id);

$categories_arr = getCategories($con);

$item = getItem($con, $id);

$bid_history_arr = getBidHistory($con, $id);

if(isset($_POST['cost'])){
    $bid = $_POST['cost'];
    $error = checkCostForError($bid, $item);
    if (!isset($error)) {
        sendBidToDB($con, $id, $bid, sess_get_user_id());
        header('Location: lot.php?id='.$id);
    }
}

$page_content = include_template('item.php', ['id' => $id, 'user_name' => $user_name, 'categories_arr' => $categories_arr, 'item_name' => $item['name'], 'img_path' => $item['img_path'],
    'category_name' => $item['category_name'], 'description' => $item['description'],
    'completion_date' => $item['completion_date'], 'current_price' => $item['current_price'],
    'min_bid' => $item['min_bid'], 'bid' => $bid ,'error' => $error, 'bid_history' => $bid_history_arr]);

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

/**
 * Проверяет введенные в форме ставки данные на корректность
 * @param mixed $bid введенная ставка
 * @param array $item текущий лот
 * @return string сообщение об ошибке
 */
function checkCostForError ($bid, array $item): ?string
{
    $message = null;
    if(!is_numeric($bid)){
        return 'Неверный формат данных';
    }
    if ($bid < $item['min_bid']) {
        return 'Введенная ставка меньше минимальной';
    }
    return $message;

}

/**
 * Отправляет проверенную ставку в БД
 * @param  mysqli $con Подключение к БД.
 * @param  int $item_id id лота.
 * @param int $bid Передаваемая ставка.
 * @param int $user_id id автора ставки.
 * @return void
  */
function sendBidToDB(mysqli $con, int $item_id, int $bid, int $user_id)
{
    $sql = "INSERT INTO bid (date, price, user_id, item_id) 
        VALUE (?, ?, ?, ?)";
    $stmt = db_get_prepare_stmt($con, $sql, [date('Y-m-d H:i:s', time()), $bid, $user_id, $item_id]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if(mysqli_errno($con)){
        printf("Connect failed: %s\n", mysqli_connect_error()); 
        die();
    }
}

/**
 * Возвращает массив с историей ставок для заданного лота.
 * @param  mysqli $con Подключение к БД.
 * @param  int $id id лота.
 * @return array Массив ставок для заданного лота.
 */
function getBidHistory (mysqli $con, int $id): array
{
    $sql = "SELECT u.name, price, date FROM bid b LEFT JOIN user u on b.user_id = u.id  WHERE item_id=? ORDER BY date DESC";
    $item = [];
    $stmt = db_get_prepare_stmt($con, $sql, [$id]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    while ($res && $row = $res->fetch_assoc()){
        $item[] = $row;
    }
    return $item;
}

function getBidDate($date){
    date_default_timezone_set('Europe/Moscow');
    $placement_date = new DateTime($date);
    $currentDate = new DateTime();
    $dt_range = $currentDate->diff($placement_date);

    
    if($dt_range->days > 0){
        return $placement_date->format("d.m.y в H:i");
    } elseif($dt_range->h > 0){
        return $dt_range->format("%h").' часа назад';
    }
    return $dt_range->format("%i").' минут назад';
}

