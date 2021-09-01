<?php
require_once('sess.php');
require_once('helpers.php');
require_once('db_connection.php');
require_once('service_functions.php');

$categories_arr = [];
$items_arr = [];

$con = db_connect();

$user_name = getUserNameById($con, sess_get_user_id());

$categories_arr = getCategories($con);

$page_content = include_template('search_tmp.php', ['categories_arr' => $categories_arr]);

$layout_content = include_template('layout.php', ['user_name' => $user_name, 'categories_arr' => $categories_arr, 'content' => $page_content ,'title' => 'Главная']);

print($layout_content);