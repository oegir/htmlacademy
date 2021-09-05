<?php

require_once('src/helpers.php');
require_once('src/database.php');
require_once('src/functions.php');

$connection = database_get_connection();
$categories = get_categories($connection);

$sql_single_lot = "
 SELECT l.`heading`, l.`description`, l.`image`, l.`finish`, c.`title` FROM lot l
JOIN category c ON l.`category_id` = c.`id`
WHERE l.`id` LIKE ?";
if (isset($_GET['id'])) {
    $single_lot_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $stmt = db_get_prepare_stmt($connection, $sql_single_lot, $data = [$single_lot_id]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $single_item = mysqli_fetch_array($res, MYSQLI_ASSOC) ?? [];

    if(!empty($single_item)) {
        $content = include_template ('single-lot.php', ['categories' => $categories, 'single_item' => $single_item]);
        }
    else {
        $error_note = 'Данной страницы не существует на сайте.';
        $content = include_template ('error.php', ['categories' => $categories, 'error_note' => $error_note]); 
        }

    $header = include_template ('header.php', ['title' => 'YetiCave', 'is_auth' => $is_auth, 'user_name' => $user_name, 'categories' => $categories]);
    $page_content = include_template ('layout.php', ['header' => $header, 'main_content' => ' ', 'single_lot_content' => $content, 'categories' => $categories]);

    print($page_content);
}
