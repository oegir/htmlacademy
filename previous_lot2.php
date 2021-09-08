<?php

require_once('src/helpers.php');
require_once('src/database.php');
require_once('src/functions.php');

$connection = database_get_connection();
$categories = get_categories($connection);

if(($item_id = intval($_GET['id'])) > 0) {
    $sql_single_lot = "
    SELECT l.`heading`, l.`description`, l.`image`, l.`finish`, c.`title` FROM lot l
JOIN category c ON l.`category_id` = c.`id`
WHERE l.`id` LIKE " . $item_id;
    
    $result_items = mysqli_query($connection, $sql_single_lot);
    $single_item = mysqli_fetch_array($result_items, MYSQLI_ASSOC) ?? [];
    $content = (empty($single_item)) ? include_template ('error.php', ['categories' => $categories]) : include_template ('single-lot.php', ['categories' => $categories, 'single_item' => $single_item]);
}
    else {
        $content = include_template ('error.php', ['categories' => $categories]);
    }

$header = include_template ('header.php', ['title' => 'YetiCave', 'is_auth' => $is_auth, 'user_name' => $user_name, 'categories' => $categories]);
$page_content = include_template ('layout.php', ['header' => $header, 'main_content' => ' ', 'single_lot_content' => $content, 'categories' => $categories]);

print($page_content);