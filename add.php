<?php
require_once('helpers.php');
require_once('db_connection.php');
require_once('service_functions.php');

$user_name = 'Artem2J'; // укажите здесь ваше имя
$incoming_data = ['lot-name' => '', 'category' => '', 'message' => '',
                  'lot-rate' => 0, 'lot-step' => 0, 'lot-date' => ''];


$form_errors = [];
if(isset($_POST['submit'])){
    $incoming_data = $_POST;
    $form_errors = checkForErrors($incoming_data, $_FILES);
}

function checkForErrors($incoming_data, $files_data): array{
    $result = [];
    if ($incoming_data['lot-name'] == ''){
        $result['lot-name'] = 'Введите наименование лота';
    }
    if ($incoming_data['category'] == 'Выберите категорию'){
        $result['category'] = 'Выберите категорию';
    }
    if ($incoming_data['message'] == ''){
        $result['message'] = 'Заполните описание';
    }
    if ((int)$incoming_data['lot-rate'] <= 0){
        $result['lot-rate'] = 'Начальная цена дожна быть больше 0';
    }
    if (!is_numeric($incoming_data['lot-step']) || (int)$incoming_data['lot-step'] <= 0){
        $result['lot-step'] = 'Шаг ставки должен быть целым положительным числом';
    }
    if($_FILES['lot-img']['error'] == 4){
        $result['lot-img'] = 'Загрузите изображение';
    }
    return $result;
}

$categories_arr = [];
$con = db_connect();
$categories_arr = getCategories($con);

$page_content = include_template('add_lot.php', ['categories_arr' => $categories_arr, 'incoming_data' => $incoming_data, 'form_errors' => $form_errors]);

$layout_content = include_template('layout.php', ['is_auth' => 1, 'user_name' => $user_name, 'categories_arr' => $categories_arr, 'content' => $page_content ,'title' => 'Добавление лота']);



print($layout_content);