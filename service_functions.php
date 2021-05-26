<?php
/**
 * Принимает дату и возвращает оставшееся время в формате массива из двух строковых переменных, часов и минут
 * @param string $date Дата.
 * @return array Массив из двух строковых переменных, часов и минут.
 */
function get_dt_range(string $date): array{
    date_default_timezone_set('Europe/Moscow');
    $expiry_date = DateTime::createFromFormat('Y-m-d', $date);
    $expiry_date->setTime(23, 59, 59);
    $currentDate = new DateTime();
    $dt_range = $currentDate->diff($expiry_date);

    $hours = 0;
    $minutes = 0;

    if (! $dt_range->invert) {
        $hours = $dt_range->days * 24 + $dt_range->h;
        $minutes = $dt_range->i;
    }

    $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
    $minutes = str_pad($minutes, 2, "0", STR_PAD_LEFT);

    return [$hours, $minutes];
}

/**
 * Обрабатывает выводимыые данные для защиты от xss-иньекций
 * @param string $string Входные данные.
 * @return string Выходные данные.
 */
function xss_protection(string $string): string{
    return htmlspecialchars($string);
}

/**
 * Выводит цену в заданном формате.
 * @param int $price Входящая цена.
 * @return string Цена в формате ХХ ХХХ Р.
 */
function price_format(int $price): string{
    return number_format(ceil($price),0, '.',' ').' ₽';
}

/**
 * Возвращает массив всех имеющихся в БД категорий.
 * @param mysqli $con Подключение к БД.
 * @return array Массив названий всех категорий.
 */
function getCategories(mysqli $con): array{
    $sql = "SELECT name, code FROM category";
    $categories = [];
    $res = mysqli_query($con, $sql);
    while ($res && $row = $res->fetch_assoc()){
        $categories[] = $row;
    }
    return $categories;
}

/**
 * Возвращает имя пользователья по заданному id.
 * @param mysqli $con Подключение к БД.
 * @param int $id id пользователя.
 * @return string Имя пользователя.
 */
function getUserNameById (mysqli $con, int $id): string{
    $sql = "SELECT name FROM user WHERE id = ?";
    $stmt = db_get_prepare_stmt($con, $sql, [$id]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $name = '';
    if ($result && $row = $result->fetch_assoc()){
        $name = $row['name'];
    }
    return $name;
}

/**
 * Возврящает id пользователья по заданному емейлу.
 * @param mysqli $con Подключение к БД.
 * @param string $email емейл искомого пользователя.
 * @return int Искомый id пользователя.
 */
function getUserIdByEmail(mysqli $con, string $email):int{
    $sql = "SELECT id FROM user WHERE email = ?";
    $stmt = db_get_prepare_stmt($con, $sql, [$email]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $id = 0;
    if ($result && $row = $result->fetch_assoc()){
        $id = $row['id'];
    }
    return $id;
}