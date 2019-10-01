<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$connect = new mysqli('localhost', 'root', '', 'ports');
$connect->query("SET NAMES 'utf8' ");

$url = parse_url($_SERVER['REQUEST_URI'])['path'];
$user_data = 0;
$roles = [
    '1' => 'Администратор',
    '2' => 'Редактор'
];
$message = null;

define('MAIN', '/ports/');
define('MANAGE', '/ports/manage');
define('LOGOUT', '/ports/logout');
define('MASS', '/ports/mass');