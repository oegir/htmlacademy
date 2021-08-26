<?php
require_once('src/helpers.php');
require_once('src/database.php');

$is_auth = rand(0, 1);
$user_name = 'Olga'; // укажите здесь ваше имя

$connection = database_get_connection();
$categories = get_categories($connection);
$items = get_lots($connection);

$header = include_template ('header.php', ['title' => 'YetiCave', 'is_auth' => $is_auth, 'user_name' => $user_name, 'categories' => $categories]);
$main_content = include_template ('main.php', ['categories' => $categories, 'items' => $items]);
$footer = include_template ('footer.php', ['categories' => $categories]);

$page_content = include_template ('layout.php', ['title' => 'Главная', 'main_content' => $main_content, 'header' => $header, 'footer' => $footer, 'categories' => $categories]);

print($page_content);
