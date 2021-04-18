<?php
require_once('helpers.php');
require_once('db_connection.php');
require_once('service_functions.php');

$con = db_connect();
$incoming_data = ['email' => '', 'password' => '', 'name' => '', 'message' => ''];
$form_errors = [];

if(isset($_POST['submit'])){
    $incoming_data = $_POST;
    $form_errors = checkRegistrationErrors($con, $incoming_data);
}

$categories_arr = [];
$categories_arr = getCategories($con);

$page_content = include_template('sign-up.php', ['categories_arr' => $categories_arr, 'incoming_data' => $incoming_data/*, 'form_errors' => $form_errors*/]);

$layout_content = include_template('layout.php', ['is_auth' => 0 ,'categories_arr' => $categories_arr, 'content' => $page_content ,'title' => 'Регистрация']);

print($layout_content);

function checkRegistrationErrors($con, $data): array{
    $result = [];


    return $result;
}