<?php
error_reporting(-1);
date_default_timezone_set('Europe/Moscow');
setlocale(LC_ALL, 'ru_RU');

$title = 'Главная';

$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];

$lots = [
    [
        'title' => '2014 Rossignol District Snowboard',
        'category' => 'Доски и лыжи',
        'price' => '10999',
        'picture' => 'img/lot-1.jpg',
        'date_finish' => '2019-08-17'
    ],
    [
        'title' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 'Доски и лыжи',
        'price' => '159999',
        'picture' => 'img/lot-2.jpg',
        'date_finish' => '2019-08-18'
    ],
    [
        'title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 'Крепления',
        'price' => '8000',
        'picture' => 'img/lot-3.jpg',
        'date_finish' => '2019-08-19'
    ],
    [
        'title' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 'Ботинки',
        'price' => '10999',
        'picture' => 'img/lot-4.jpg',
        'date_finish' => '2019-08-21'
    ],
    [
        'title' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 'Одежда',
        'price' => '7500',
        'picture' => 'img/lot-5.jpg',
        'date_finish' => '2019-08-25'
    ],
    [
        'title' => 'Маска Oakley Canopy',
        'category' => 'Разное',
        'price' => '5400',
        'picture' => 'img/lot-6.jpg',
        'date_finish' => '2019-08-29'
    ]
];