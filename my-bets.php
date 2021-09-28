<?php
require_once('sess.php');
require_once('helpers.php');
require_once('db_connection.php');
require_once('service_functions.php');

$con = db_connect();

sess_check_auth();

$user_id = sess_get_user_id();

$user_name = getUserNameById($con, $user_id);

$categories_arr = [];
$categories_arr = getCategories($con);

$bets_arr = [];

$page_content = include_template('my-bets_tmp.php', ['categories_arr' => $categories_arr, 'bets_arr' => $bets_arr]);

$layout_content = include_template('layout.php', ['user_name' => $user_name, 'categories_arr' => $categories_arr, 'content' => $page_content ,'title' => 'Добавление лота']);

print($layout_content);