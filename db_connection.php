<?php
function db_connect(){
    $con = mysqli_connect('localhost', 'root', 'root', 'yeticave');
    if ($con == false){
        print ("Ошибка подключения" . mysqli_connect_error());
    die();
    }
    mysqli_set_charset($con, "utf8");
    return $con;
}