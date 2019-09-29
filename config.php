<?php
$connect = new mysqli('localhost', 'root', '', 'ports');
$connect->query("SET NAMES 'utf8' ");

$url = parse_url($_SERVER['REQUEST_URI'])['path'];
$user_data = 0;
$roles = [
    '1' => 'Администратор',
    '2' => 'Редактор'
];

define('MAIN', '/ports/');
define('MANAGE', '/ports/manage');
define('LOGOUT', '/ports/logout');