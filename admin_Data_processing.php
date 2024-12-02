<?php

    include_once('Data_processing.php');
    include_once('technical.php');

    class admin_Data_processing extends Data_processing{

        private array $admin_data_first_time;
        private array $admin_data_second_time;
        private array $admin_data_route;

        public function __construct(array $admin_first_time, array $admin_second_time, array $admin_route){

            $this -> admin_data_first_time = $admin_first_time;
            $this -> admin_data_second_time = $admin_second_time;
            $this -> admin_data_route = $admin_route;  

        }

        // удаляю/прибавляю время начала/конца пути
        private function admin_data_change_time(string $admin_data_operator, array &$admin_data_time) : void {

            $admin_data_average = $this -> data_average_time_betwin_stop($this -> admin_data_first_time, $this -> admin_data_second_time, $this -> admin_data_route);

            foreach($admin_data_time as &$admin_data_t){

                $admin_data_t -> modify($admin_data_operator . $admin_data_average . ' minutes');

            }

        }

        //прибавляю/убавляю время у маршрута в связи с изменением оного
        private function admin_data_reset_time_average(int $admin_delete, int $admin_add) : void {

            if($admin_delete && $admin_add) return;

            if($admin_add){

                $this -> admin_data_change_time('+', $this -> admin_data_second_time);

            }

            if($admin_delete){

                $this -> admin_data_change_time('-', $this -> admin_data_second_time);

            }

        }

        // меняем входные данные в связи с запросом
        private function admin_data_processing(int $admin_route, int $admin_delete, int $admin_add) : void {


            if($admin_add && ($admin_route != 1)){

                $this -> admin_data_route[] = $admin_add;

            }elseif($admin_add && ($admin_route == 1)){

                $this -> admin_data_route[] = $admin_add;
                $this -> admin_data_reset_time_average($admin_delete, $admin_add);

            }

            $admin_data_search = array_search($admin_delete, $this -> admin_data_route);

            if($admin_delete && ($admin_route != 1) && ($admin_data_search !== false)){

                unset($this -> admin_data_route[$admin_data_search]);

            }elseif($admin_delete && ($admin_route == 1) && ($admin_data_search !== false)){

                unset($this -> admin_data_route[$admin_data_search]);
                $this -> admin_data_reset_time_average($admin_delete, $admin_add);

            }

        }

        //массив с датами в текст
        private function admin_data_to_string(array &$admin_data_time) : void {

            foreach($admin_data_time as &$admin_data_t){

                $admin_data_t = $admin_data_t -> format('H:i');

            }

        }

        //получаем sql запрос
        public function admin_data_sql_get(int $admin_bus_name, int $admin_route, int $admin_delete, int $admin_add) : string{

            $this -> admin_data_processing($admin_route, $admin_delete, $admin_add);

            $this -> admin_data_to_string($this -> admin_data_first_time);
            $this -> admin_data_to_string($this -> admin_data_second_time);

            print_r(technical_array_to_string($this -> admin_data_first_time));
            print('<hr>');
            print_r(technical_array_to_string($this -> admin_data_second_time));
            print('<hr>');
            print_r(technical_array_to_string(array_unique($this -> admin_data_route)));
            print('<hr>');

            $admin_data_way = ($admin_route == 1) ? 'first' : 'second';

            $sql = 'WITH update_time_route AS (
                    UPDATE time_route
                    SET time_first_way = \'' . technical_array_to_string($this -> admin_data_first_time) . '\',
                        time_second_way = \'' . technical_array_to_string($this -> admin_data_second_time) . 
                '\' WHERE time_id = ' . $admin_bus_name . 
                  ' RETURNING time_id),
                    update_routes AS (
                    UPDATE routes
                    SET route_' . $admin_data_way . '_way = \''. technical_array_to_string(array_unique($this -> admin_data_route)) .
                '\' WHERE 
                    route_id = ' . $admin_bus_name . '
                    RETURNING route_id)
                    SELECT update_time_route.time_id, update_routes.route_id
                    FROM update_time_route, update_routes;';

            return $sql;

        }

    }