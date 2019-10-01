<?php
require 'config.php';
require 'functions.php';

function apply_sql($sql) {
    global $connect;
    $res = $connect->query($sql);
    if ($res) {
        echo 'success';
    } else {
        echo $connect->error;
    }
}

function change_ip_data($id, $ip, $port) {
    $sql = "UPDATE `proxys` SET `ip`='$ip', `port`='$port' WHERE `id`='$id'";
    apply_sql($sql);
}

function delete_ip($id) {
    $sql = "DELETE FROM `proxys` WHERE `id`=$id";
    apply_sql($sql);
}

if(isset($_POST['ip_change']) && isset($_POST['port_change']) && isset($_POST['id'])) {
    change_ip_data($_POST['id'], $_POST['ip_change'], $_POST['port_change']);
}
if(isset($_POST['delete_ip'])) {
    delete_ip($_POST['delete_ip']);
}