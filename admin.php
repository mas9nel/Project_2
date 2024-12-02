<?php

    include_once('Bus.php');
    include_once('db_connect.php');
    include_once('Stop.php');
    include_once('Time.php');
    include_once('Route.php');
    include_once('admin_Data_processing.php');
    
    $admin_bus_name = ($_GET['admin_visualization_bus_name']) ? (int)(htmlentities($_GET['admin_visualization_bus_name'])) : false;
    $admin_route = ($_GET['admin_visualization_route']) ? (int)(htmlentities($_GET['admin_visualization_route'])) : false;
    $admin_delete = ($_GET['admin_visualization_delete']) ? (int)(htmlentities($_GET['admin_visualization_delete'])) : false;
    $admin_add = ($_GET['admin_visualization_add']) ? (int)(htmlentities($_GET['admin_visualization_add'])) : false;

    if(($admin_bus_name && $admin_route) && ($admin_delete || $admin_add) && ($admin_delete != $admin_add)){
        
        $admin_sql_request_necessary_bus = 'SELECT b.bus_name AS bus_route_name, t_r.time_first_way AS bus_time_first_way, t_r.time_second_way AS bus_time_second_way, ';
        
        if($admin_route == 1) { 

            $admin_sql_request_necessary_bus .= 'r.route_first_way AS bus_route_way ';

        }elseif($admin_route == 2){

            $admin_sql_request_necessary_bus .= 'r.route_second_way AS bus_route_way ';

        }
                                        
        $admin_sql_request_necessary_bus .= 'FROM buses AS b
                                             JOIN routes AS r
                                             ON b.bus_id = r.route_id
                                             JOIN time_route AS t_r
                                             ON b.bus_id = t_r.time_id
                                             Where b.bus_id =' . $admin_bus_name;
        
        
        $admin_request_necessary_bus = pg_query($db_connect, $admin_sql_request_necessary_bus);
        if(!$admin_request_necessary_bus) die('Ошибка: некорректный запрос к базе данных');

        while($admin_r_n_b = pg_fetch_array($admin_request_necessary_bus)){

            $admin_time = (new Time()) -> set_time_first_way($admin_r_n_b['bus_time_first_way']) -> set_time_second_way($admin_r_n_b['bus_time_second_way']);
            $admin_bus_route = (new Route()) -> set_first_way($admin_r_n_b['bus_route_way']);

            $admin_data_processing = new admin_Data_processing($admin_time -> get_time_first_way(), $admin_time -> get_time_second_way(), $admin_bus_route -> get_first_way());

            $admin_sql_request_add_delete = $admin_data_processing -> admin_data_sql_get($admin_bus_name, $admin_route, $admin_delete, $admin_add);
            
            $admin_request_add_delete = pg_query($db_connect, $admin_sql_request_add_delete);
            if(!$admin_request_add_delete) die('Ошибка: некорректный запрос к базе данных');
        }

    }

?>