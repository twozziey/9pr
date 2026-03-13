<?php
    header("Access-Control-Allow-Origin: *"); 
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
    header("Access-Control-Allow-Headers: Content-Type"); 
    header("Access-Control-Allow-Credentials: true");
    include("connect_datebase.php");

    $key = "qwerty";

    $login = $_POST["login"];
    $password = $_POST["password"];

    $query = $mysqli->query("SELECT * FROM `users` WHERE `login`='".$login."'");

    if($user = $query->fetch_assoc()) {
        if($user['password'] == $password) {
            $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
            $payload = json_encode(['userId'=> $user['id'],'roll'=> $user['roll'],'exp' => time() + 3600]);
            function base64UrlEncode($data) {
                return str_replace(['+','/','='],['-','_',''], base64_encode($data));
            }

            $base64UrlHeader = base64UrlEncode($header);
            $base64UrlPayload = base64UrlEncode($payload);

            $signature = hash_hmac('sha256',$base64UrlHeader . "." . $base64UrlPayload, $key, true);
            $base64UrlSignature = base64UrlEncode($signature);

            $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

            echo $jwt;
            exit;
        }
    }
?>