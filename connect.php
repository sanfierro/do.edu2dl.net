<?php

    $host = "eu6.dominant.lt:3306";
    $user = "e32270_dbuser";
    $password = "!6985Vdk21";
    $database = "e32270_worksdb";
    
    // подключаемся к серверу
    $link = mysqli_connect($host, $user, $password, $database) 
        or die("Помилка " . mysqli_error($link));
    mysqli_set_charset($link, "utf8");

?>
