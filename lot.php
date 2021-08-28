<?php
require_once('src/helpers.php');
require_once('src/database.php');


$connection = database_get_connection();
$categories = get_categories($connection);
$single_item = get_single_lot($connection);


$single_lot = include_template ('single-lot.php', ['categories' => $categories, 'single_item' => $single_item]);
$header = include_template ('header.php', ['title' => 'YetiCave', 'is_auth' => $is_auth, 'user_name' => $user_name, 'categories' => $categories]);
$footer = include_template ('footer.php', ['categories' => $categories]);
$error = include_template ('error.php', ['categories' => $categories]);

if ($single_item) { 
    $page_content = include_template ('layout.php', ['header' => $header, 'main_content' => ' ', 'single_lot' => $single_lot, 'error' => ' ', 'footer' => $footer]);
}
else {
    $page_content = include_template ('layout.php', ['header' => $header, 'error' => $error, 'footer' => $footer, 'main_content' => ' ', 'single_lot' => ' ']);
}
print($page_content);
