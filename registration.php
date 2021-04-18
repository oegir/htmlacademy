<?php
require_once('helpers.php');
require_once('db_connection.php');
require_once('service_functions.php');

$con = db_connect();
$user_name = 'Artem2J'; // укажите здесь ваше имя
$incoming_data = ['lot-name' => '', 'category' => '', 'message' => '',
                  'lot-rate' => 0, 'lot-step' => 0, 'lot-date' => ''];

$form_errors = [];

$categories_arr = [];
$categories_arr = getCategories($con);

$page_content = include_template('sign-up.php', ['categories_arr' => $categories_arr/*, 'incoming_data' => $incoming_data, 'form_errors' => $form_errors*/]);

$layout_content = include_template('layout.php', ['is_auth' => 0 ,'categories_arr' => $categories_arr, 'content' => $page_content ,'title' => 'Регистрация']);

print($layout_content);