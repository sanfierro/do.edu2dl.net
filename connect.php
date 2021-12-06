<?php

    $host = "eu-cdbr-west-01.cleardb.com:3306";
    $user = "bc948ba523b8ff";
    $password = "7c356faa";
    $database = "heroku_3077959cedd490a";
    
    // подключаемся к серверу
    $link = mysqli_connect($host, $user, $password, $database) 
        or die("Помилка " . mysqli_error($link));
    mysqli_set_charset($link, "utf8");
?>
