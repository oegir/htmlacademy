<?php

function get_dt_range($date): array{
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

function xss_protection($string): string{
    return htmlspecialchars($string);
}

function price_format($price): string{
    return number_format(ceil($price),0, '.',' ').' ₽';
}

function getCategories(mysqli $con): array{
    $sql = "SELECT name, code FROM category";
    $categories = [];
    $res = mysqli_query($con, $sql);
    while ($res && $row = $res->fetch_assoc()){
        $categories[] = $row;
    }
    return $categories;
}

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