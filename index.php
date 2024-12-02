<?php 

    include_once('db_connect.php');
    include_once('Stop.php');
    include_once('Bus.php');
    include_once('Route.php');
    include_once('Data_processing.php');
    include_once('Data.php');
    include_once('Time.php');

    $visualization_from = ($_GET['visualization_from']) ? (int)(htmlentities($_GET['visualization_from'])) : false;
    $visualization_to = ($_GET['visualization_to']) ? (int)(htmlentities($_GET['visualization_to'])) : false;

    $index_stop = new Stop();

    $index_sql_reqest_stop = 'SELECT stop_name FROM stop';
    $index_request_stop = pg_query($db_connect, $index_sql_reqest_stop);
    if(!$index_request_stop) die('Ошибка: некорректный запрос к таблице "stop"');

    $index_sql_reqest_bus = 'SELECT b.bus_name AS bus_route_name, r.route_first_way AS bus_route_first_way,
                                   r.route_second_way AS bus_route_second_way, t_r.time_first_way AS bus_time_first_way,
                                   t_r.time_second_way AS bus_time_second_way
                            FROM buses AS b
                            JOIN routes AS r
                            ON b.bus_id = r.route_id
                            JOIN time_route AS t_r
                            ON b.bus_id = t_r.time_id
                            WHERE (r.route_first_way LIKE \'%' . $visualization_from . '%\'
                                  OR r.route_second_way LIKE \'%' . $visualization_from . '%\')
                                  AND (r.route_first_way LIKE \'%' . $visualization_to . '%\'
                                  OR r.route_second_way LIKE \'%' . $visualization_to . '%\')';
    $index_request_bus = pg_query($db_connect, $index_sql_reqest_bus);
    if(!$index_request_bus) die('Ошибка: некорректный запрос к базе данных');

    //получаем массив остановок
    while($index_r_s = pg_fetch_array($index_request_stop)){

        $index_stop -> stop_set($index_r_s['stop_name']);
        
    }

    $index_data = new Data($visualization_from, $visualization_to, $index_stop -> stop_get());

    //получаем именной массив с необходимыми данными для 1 части задачи
    while ($index_r_b = pg_fetch_array($index_request_bus)){
        
        $bus = (new Bus()) -> set_bus_name($index_r_b['bus_route_name']);
        $route = (new Route) -> set_first_way($index_r_b['bus_route_first_way']) -> set_second_way($index_r_b['bus_route_second_way']);
        $time = (new Time) -> set_time_first_way( $index_r_b['bus_time_first_way']) -> set_time_second_way($index_r_b['bus_time_second_way']);

        $data_processing = new Data_processing( $bus -> get_bus_name(), $route -> get_first_way(), $route -> get_second_way(), 
                                                $time -> get_time_first_way(), $time -> get_time_second_way());

        if($index_check_path = $data_processing -> data_check_path ($visualization_from, $visualization_to)){

            $index_data -> data_add_bus( $data_processing -> get_data( $index_stop -> stop_get(), $visualization_from, $visualization_to, $index_check_path));

        }
 
    }
?>