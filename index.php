<?php
require_once('helpers.php');
$is_auth = rand(0, 1);

$user_name = 'Olga'; // укажите здесь ваше имя

$base = mysqli_connect('localhost', 'root', '', 'yeticave'); 
   mysqli_set_charset($base, "utf8"); 
    if (!$base) {
        echo "Ошибка подключения к БД. Код ошибки: " . mysqli_connect_error();
        exit();
    }

$sql_categories = "SELECT `id`, `title`, `symbol` FROM category";
$result_categories = mysqli_query($base, $sql_categories); 
$categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);

$sql_items = "SELECT l.`id`, l.`create`, l.`heading`, l.`first_price`, l.`price_step`, l.`finish`, l.`image`, c.`title` FROM lot l
JOIN category c ON l.`category_id` = c.`id`
WHERE l.`finish` > CURDATE()
ORDER BY `create` DESC";
$result_items = mysqli_query($base, $sql_items);
$items = mysqli_fetch_all($result_items, MYSQLI_ASSOC);

/**
 * Форматирует цену по шаблону
 *
 * @param string $price целое число
 * @return $format_price . " ₽" отформатированная сумма вместе со знаком рубля
 */
function auction_price($price) {
    $format_price = ceil($price);
    $format_price = number_format($format_price, 0, ' ', ' ');
    return $format_price . " ₽";
}
/**
 * Выводит разницу во времени в формате 'ЧЧ:ММ'
 *
 * @param string $finishing дата в формате 'ГГГГ-ММ-ДД'
 * @return array $diff_array массив, где первый элемент — целое количество часов до даты, а второй — остаток в минутах
 */
function date_finishing($finishing) {
    $date_now = date_create('now');
    $date_finishing = date_create($finishing);
    $diff = (array) date_diff($date_now, $date_finishing);
    $diff_array = [
        'hours' => str_pad(($diff['d']*24 + $diff['h']), 2, "0", STR_PAD_LEFT),
        'minutes' => str_pad($diff['i'], 2, "0", STR_PAD_LEFT)
    ];
    return($diff_array);
}


$main_content = include_template ('main.php', ['categories' => $categories, 'items' => $items]);
$page_content = include_template ('layout.php', ['title' => 'Главная', 'is_auth' => $is_auth, 'user_name' => $user_name, 'main_content' => $main_content, 'categories' => $categories]);

print($page_content);
