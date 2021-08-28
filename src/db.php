<?php 
/**
 * @file
 *
 * File contains functions for work with MySql database
 */

define('DB_HOST', 'localhost');
define('DB_BASE_NAME', 'readme');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

/**
 * Connect to DB
 *
 * @return mysqli
 */
function dbGetConnection(): mysqli
{
    $mysql = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_BASE_NAME);
    mysqli_set_charset($mysql, 'utf8');
    
    if ($mysql === false) {
        print ("Ошибка подключения: ".mysqli_connect_error());
        exit();
    }
    
    return $mysql;
}