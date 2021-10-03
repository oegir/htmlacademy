<?php
require_once('src/helpers.php');
require_once('src/database.php');
require_once('src/functions.php');
require_once('src/templates.php');


$main_content = include_template ('main.php', [
    'categories' => $categories, 
    'items' => $items
]);

$page_content = include_template ('layout.php', [
    'title' => 'YetiCave', 
    'categories' => $categories, 
    'header' => $header, 
    'top_menu' => '', 
    'main_content' => $main_content, 
    'single_lot_content' => ''
]);

print($page_content);
