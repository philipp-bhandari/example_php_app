<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$connect = new mysqli('localhost', 'feelsever', 'victoria1', 'ports');
$connect->query("SET NAMES 'utf8' ");

$url = parse_url($_SERVER['REQUEST_URI'])['path'];
$user_data = 0;
$roles = [
    '1' => 'Администратор',
    '2' => 'Редактор'
];
$message = null;

define('MAIN', '/example_php_app/');
define('MANAGE', '/example_php_app/manage');
define('LOGOUT', '/example_php_app/logout');
define('MASS', '/example_php_app/mass');