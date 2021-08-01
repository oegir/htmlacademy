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

/**
 * Рассчет разницы во времени между текущей и переданной датой
 * 
 * @param string $finishing дата в формате ГГГГ-ММ-ДД
 * @return array ['hour' => string часы, 'minute' => int string]
 */
function date_finishing(string $finishing): array
{
    $now = date_create('now');
    $final = date_create($finishing);
    $final->setTime(23, 59, 59);
    $diff = date_diff($now, $final);
    
    $hour = str_pad($diff->days * 24 + $diff->h, 2, '0', STR_PAD_LEFT);
    $minute = str_pad($diff->i, 2, '0', STR_PAD_LEFT);
    
    return [
        'hour' => $hour,
        'minute' => $minute
    ];
}


$main_content = include_template ('main.php', ['categories' => $categories, 'items' => $items]);
$page_content = include_template ('layout.php', ['title' => 'Главная', 'is_auth' => $is_auth, 'user_name' => $user_name, 'main_content' => $main_content, 'categories' => $categories]);

print($page_content);
