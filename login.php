<?php 
require_once('helpers.php');
require_once('db_connection.php');
require_once('service_functions.php');
session_start();

$categories_arr = [];
$items_arr = [];

$con = db_connect();

$categories_arr = getCategories($con);

$form_errors =[];
$incoming_data = ['email' => '', 'password' => '', 'name' => '', 'message' => ''];

if(isset($_POST['submit'])){
    $incoming_data = $_POST;
    $form_errors = checkLoginErrors($con, $incoming_data);
}
$page_content = include_template('login_form.php', ['categories_arr' => $categories_arr, 'incoming_data' => $incoming_data, 'form_errors' => $form_errors]);

$layout_content = include_template('layout.php', ['categories_arr' => $categories_arr, 'content' => $page_content ,'title' => 'Вход']);

print($layout_content);

function checkLoginErrors(mysqli $con, array $data): array{
    $result = [];
    $result['email'] = checkEmail($con, $data['email']);
    return $result;
}
function checkEmail(mysqli $con, string $email): string{
    if($email == ''){
        return 'Введите e-mail';
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return 'Введен некорректный e-mail';
    }

    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = db_get_prepare_stmt($con, $sql, [$email]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $result = mysqli_num_rows($res) == 0 ? true: false; 
    
    if ($result){
        return 'Пользователь с введенным email отсутствует';
    }
    return '';
}