<?php
function get_ip_list() {
    global $connect;

    $sql = "SELECT * FROM `proxys`";
    $result = $connect->query($sql);
    $result_arr = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()) {
            $result_arr[] = [$row['ip'], $row['port'], $row['id']];
        }
    }

    return $result_arr;
}

function check_login($login, $password) {
    global $connect;

    $sql = "SELECT * FROM `users` WHERE `login`='$login'";
    $result = $connect->query($sql);
    $base_pass = null;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()) {
            $base_pass = $row['pass'];
        }
    } else {
        return 0;
    }

    $res = $password == $base_pass ? 1 : 0;
    return $res;
}

function set_user_token($login, $token) {
    global $connect;
    $sql = "UPDATE `users` SET `token`='$token' WHERE `login`='$login'";
    $res = $connect->query($sql) ? 1 : 0;
    return $res;
}

function is_correct_auth($token) {
    global $connect;

    $sql = "SELECT * FROM `users` WHERE `token`='$token'";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()) {
            return [
                'id'    => $row['id'],
                'login' => $row['login'],
                'role'  => $row['role']
            ];
        }
    } else {
        return 0;
    }
}

function get_users_list($self_id) {
    global $connect;
    $sql = "SELECT * FROM `users` WHERE `id` != '$self_id'";
    $result = $connect->query($sql);
    $result_arr = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()) {
            $result_arr[] = [
                'id'    => $row['id'],
                'login' => $row['login'],
                'role'  => $row['role']
            ];
        }
    } else {
        return 0;
    }

    return $result_arr;
}

//function open_file($path) {
//    if(file_exists($path)){
//        $file = fopen($path, 'r');
//        if($file) {
//            return $file;
//        } else {
//            throw new Exception('Unable to open file: ' . $path);
//        }
//    } else {
//        throw new Exception('File ' . $path . ' not exist');
//    }
//}
//
//function save_csv($path){
//        $file = open_file($path);
//        fgetcsv($file); # Пропускаем первую строку
//
//        while (!feof($file)) {
//            $data = fgetcsv($file);
//            if(filter_var($data[0], FILTER_VALIDATE_IP) && isset($data[1])){
//                global $connect;
//
//                $sql = "INSERT INTO `proxys`(`ip`, `port`) VALUES ('$data[0]', $data[1])";
//                if (!$connect->query($sql) === TRUE) {
//                    throw new Exception("Error: " . $sql . "<br>" . $connect->error . '<br><br>');
//                }
//
//            } else {
//                throw new Exception('String ' . $data[0] . ':' . $data[1] . ' not IP-adress');
//            }
//        }
//
//}