<?php
require_once('p/helpers.php');
require_once('p/database.php');

$is_auth = rand(0, 1);
$user_name = 'Olga'; // укажите здесь ваше имя

$connection = database_get_connection();
$categories = get_categories($connection);
$items = get_lots($connection);

$main_content = include_template ('main.php', ['categories' => $categories, 'items' => $items]);
$page_content = include_template ('layout.php', ['title' => 'Главная', 'is_auth' => $is_auth, 'user_name' => $user_name, 'main_content' => $main_content, 'categories' => $categories]);

print($page_content);
