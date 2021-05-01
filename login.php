<?php 
require_once('helpers.php');
require_once('db_connection.php');
require_once('service_functions.php');

$is_auth = rand(0, 1);

$categories_arr = [];
$items_arr = [];

$con = db_connect();

$categories_arr = getCategories($con);

$user_name = 'Artem2J'; // укажите здесь ваше имя

$incoming_data = $form_errors =[];

$page_content = include_template('login_form.php', ['categories_arr' => $categories_arr, 'incoming_data' => $incoming_data, 'form_errors' => $form_errors]);

$layout_content = include_template('layout.php', ['is_auth' => $is_auth, 'user_name' => $user_name, 'categories_arr' => $categories_arr, 'content' => $page_content ,'title' => 'Вход']);

print($layout_content);