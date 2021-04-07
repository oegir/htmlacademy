<?php
require_once('helpers.php');
require_once('db_connection.php');
require_once('service_functions.php');

$user_name = 'Artem2J'; // укажите здесь ваше имя
$incoming_data = [];
if(isset($_POST['submit'])){
    $incoming_data = $_POST;
    
}

$categories_arr = [];
$con = db_connect();
$categories_arr = getCategories($con);

$page_content = include_template('add_lot.php', ['categories_arr' => $categories_arr]);

$layout_content = include_template('layout.php', ['is_auth' => 1, 'user_name' => $user_name, 'categories_arr' => $categories_arr, 'content' => $page_content ,'title' => 'Добавление лота']);



print($layout_content);