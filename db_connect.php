<?php
    //подключение базы данных
    $db_connect = pg_connect('host=127.0.0.1 port=5432 user=postgres'); 
    if(!$db_connect) die('Ошибка подключения базы данных');