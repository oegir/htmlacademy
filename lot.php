<?php

require_once('src/helpers.php');
require_once('src/database.php');
require_once('src/functions.php');
require_once('src/templates.php');

$connection = database_get_connection();

$sql_single_lot = "
 SELECT l.`heading`, l.`description`, l.`image`, l.`first_price`, l.`finish`, c.`title` FROM lot l
JOIN category c ON l.`category_id` = c.`id`
WHERE l.`id` = ?";

if (!empty($_GET['id'])) {
    $set_id = $_GET['id'];

    if ($set_id = true) {
        
        $single_lot_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $stmt = db_get_prepare_stmt($connection, $sql_single_lot, [$single_lot_id]);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $single_item = mysqli_fetch_array($res, MYSQLI_ASSOC) ?? [];

        if(!empty($single_item)) {
            $categories = get_categories($connection);
            $content = include_template ('single-lot.php', ['categories' => $categories, 'single_item' => $single_item]);
            }
        else {
            $error = "Данной страницы не существует на сайте";
            $content = show_error($content, $error);
            }

            print_page($content, $connection);
    }
    else {
        $error = "Данной страницы не существует на сайте";
        show_error($content, $error);
    }
}
else {
    header('HTTP/1.1 403 Forbidden');
}