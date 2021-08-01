<?php
require_once('helpers.php');
$is_auth = rand(0, 1);

$user_name = 'Olga'; // укажите здесь ваше имя

$categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];

$items = [
    [
        'title' => '2014 Rossignol District Snowboard',
        'category' => 'Доски и лыжи',
        'price' => '10999',
        'img' => 'img/lot-1.jpg',
        'finishing' => '2021-08-04'
    ],
    [
        'title' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'Доски и лыжи',
        'price' => '159999',
        'img' => 'img/lot-2.jpg',
        'finishing' => '2021-08-03'
    ],
    [
        'title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'price' => '8000',
        'img' => 'img/lot-3.jpg',
        'finishing' => '2021-08-04'
    ],
    [
        'title' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'Ботинки',
        'price' => '10999',
        'img' => 'img/lot-4.jpg',
        'finishing' => '2021-08-02'
    ],
    [
        'title' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'Одежда',
        'price' => '7500',
        'img' => 'img/lot-5.jpg',
        'finishing' => '2021-08-06'
    ],
    [
        'title' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'price' => '5400',
        'img' => 'img/lot-6.jpg',
        'finishing' => '2021-08-07'
        ]
];

function auction_price($price) {
    $format_price = ceil($price);
    $format_price = number_format($format_price, 0, ' ', ' ');
    return $format_price . " ₽";
}

function date_finishing($finishing) {
    $date1 = date_create('now');
    $date2 = date_create($finishing);
    $diff = date_diff($date1, $date2);
    $time_count = date_interval_format($diff, '%d %H %i');
    $time_count_array = explode(' ', $time_count);
    $time_count_array[1] = $time_count_array[0]*24 + $time_count_array[1];
    return $time_count_array[1] . ":" . $time_count_array[2];
}


$main_content = include_template ('main.php', ['categories' => $categories, 'items' => $items]);
$page_content = include_template ('layout.php', ['title' => 'Главная', 'is_auth' => $is_auth, 'user_name' => $user_name, 'main_content' => $main_content, 'categories' => $categories]);

print($page_content);
