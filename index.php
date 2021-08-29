<?php
require_once('helpers.php');
require_once ('function.php');
require_once ('db.php');

$is_auth = rand(0, 1);
$user_name = 'Андрей';


/**
 * Подключаем шаблоны
 */
$page_content = include_template('main.php', ['postListRows' => $postListRows]);
$layout_content = include_template(
    'layout.php',
    [
        'content' => $page_content,
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'title' => 'readme: популярное',

    ]
);
print($layout_content);


?>

