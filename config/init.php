<?php

session_start();

$db = [
    'host' => '601235-yeticave-10',
    'user' => 'root',
    'password' => '',
    'database' => 'yeticave_db'
];

$con = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($con, 'utf8');