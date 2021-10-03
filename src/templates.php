<?php

$connection = database_get_connection();
$categories = get_categories($connection);
$items = get_lots($connection);

if (!$connection) {
    $error = mysqli_connect_error();
    show_error($content, $error);
}

$header = include_template ('header.php', [
    'title' => 'YetiCave', 
    'is_auth' => $is_auth, 
    'user_name' => $user_name, 
]);

$top_menu = include_template ('top-menu.php', [
    'categories' => $categories
]);