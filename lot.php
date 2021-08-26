<?php
require_once('src/helpers.php');
require_once('src/database.php');


$connection = database_get_connection();
$categories = get_categories($connection);
$single_item = get_single_lot($connection);

$footer = include_template ('footer.php', ['categories' => $categories]);
$page_content = include_template ('single-lot.php', ['categories' => $categories, 'footer' => $footer, 'single_item' => $single_item[0]]);

print($page_content);