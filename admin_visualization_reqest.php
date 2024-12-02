<?php
    //берем данные о маршрутах и остановках для визуализации admin
    include_once('Bus.php');
    include_once('db_connect.php');
    include_once('Stop.php');

    $admin_stop = new Stop();
    $admin_bus = new Bus();

    $admin_sql_reqest_bus = 'SELECT bus_name FROM buses';

    $admin_request_bus = pg_query($db_connect, $admin_sql_reqest_bus);
    if(!$admin_request_bus) die('Ошибка: некорректный запрос к таблице "busses"');
    
    $admin_sql_reqest_stop = 'SELECT stop_name FROM stop';
    $admin_request_stop = pg_query($db_connect, $admin_sql_reqest_stop);
    if(!$admin_request_stop) die('Ошибка: некорректный запрос к таблице "stop"');

    while($admin_r_s = pg_fetch_array($admin_request_stop)){

        $admin_stop -> stop_set($admin_r_s['stop_name']);
        
    }

    while($admin_r_b = pg_fetch_array($admin_request_bus)){

        $admin_bus -> add_bus_names_admin($admin_r_b['bus_name']);

        
    }