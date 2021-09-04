<?php
require_once('src/helpers.php');
require_once('src/database.php');
require_once('src/functions.php');

$connection = database_get_connection();
$categories = get_categories($connection);
$items = get_lots($connection);

$header = include_template ('header.php', [
    'title' => 'YetiCave', 
    'is_auth' => $is_auth, 
    'user_name' => $user_name, 
    'categories' => $categories
]);

$main_content = include_template ('main.php', [
    'categories' => $categories, 
    'items' => $items
]);

$page_content = include_template ('layout.php', [
    'title' => 'YetiCave', 
    'categories' => $categories, 
    'header' => $header,  
    'main_content' => $main_content, 
    'single_lot_content' => ' '
]);

print($page_content);
