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

$page_content = include_template('sign-up.php', ['categories_arr' => $categories_arr, 'incoming_data' => $incoming_data, 'form_errors' => $form_errors]);

$layout_content = include_template('layout.php', ['is_auth' => 0 ,'categories_arr' => $categories_arr, 'content' => $page_content ,'title' => 'Регистрация']);

print($layout_content);

function checkRegistrationErrors($con, $data): array{
    $result = [];
    if ($data['email'] == ''){
        $result['email'] = 'Введите e-mail';
    }elseif (checkEmail($con, $data['email'])){
        $result['email'] = 'Данный email занят';
    }
    if ($data['password'] == ''){
        $result['password'] = 'Введите пароль';
    }
    if ($data['name'] == ''){
        $result['name'] = 'Введите имя';
    }
    if ($data['message'] == ''){
        $result['message'] = 'Введите контактные данные';
    }

    return $result;
}

function checkEmail($con, $email): bool{
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = db_get_prepare_stmt($con, $sql, [$email]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $result = mysqli_num_rows($res) == 0 ? false: true; 
    
    return $result;
}