<?php
    include("../settings/connect_datebase.php");
    include("./token_verify.php");

    if(!isset($_COOKIE['token'])) {
        http_response_code(401);
        exit;
    }

    $data = tokenVerify($_COOKIE['token']);

    if(!$data) {
        http_response_code(401);
        exit;
    }

    $IdUser = (int)$data['userId'];
    $Message = $mysqli->real_escape_string($_POST["Message"]);
    $IdPost = (int)$_POST["IdPost"];

    $mysqli->query("INSERT INTO `comments`(`IdUser`, `IdPost`, `Messages`) VALUES ($IdUser, $IdPost, '$Message')");
?>