<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'config.php';
require 'functions.php';

if($url == MAIN) {
    $page = 'Ports';
    $ip_list = get_ip_list();

} elseif ($url == MANAGE) {
    $page = 'Manage';
    if(isset($_POST['login']) && isset($_POST['pass'])) {
        $login = $_POST['login'];
        $pass = $_POST['pass'];

        $is_correct = check_login($login, $pass);
        if($is_correct) {
            $token = session_id();
            $res = set_user_token($login, $token);
        }
    }
} elseif ($url == LOGOUT && session_status() == PHP_SESSION_ACTIVE) {
    $page = 'Logout';
    unset($_COOKIE['PHPSESSID']);
    setcookie('PHPSESSID', null, -1, '/');
    session_destroy();
}

if(isset($_COOKIE['PHPSESSID'])) {
    $token = $_COOKIE['PHPSESSID'];

    if($token) {
        $user_data = is_correct_auth($token); # return id, login, role
    }

}



include 'template.php';
//
//
//# Сохранить csv
//try{
//    //save_csv('ports.csv');
//} catch (Exception $e) {
//    echo 'Ошибка: ', $e->getMessage(), '<br>';
//}