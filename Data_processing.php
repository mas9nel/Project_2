<?php

    class Data_processing{

        private string $data_bus_name;
        private array $data_route_first_way;
        private array $data_route_second_way;
        private array $data_time_first_way; 
        private array $data_time_second_way;


        public function __construct(string $index_rout_name, array $index_route_first_way, array $index_route_second_way, array $index_time_first_way, array $index_time_second_way){

            $this -> data_bus_name = $index_rout_name;

            $this -> data_route_first_way = $index_route_first_way;
            $this -> data_route_second_way = $index_route_second_way;

            $this -> data_time_first_way = $index_time_first_way;
            $this -> data_time_second_way = $index_time_second_way;

        }

        //проверка на наличие маршрута
        private function data_finde_way(int $get_from, int $get_to, array $bus_way) : bool {
            
            $data_bus_start_way = array_search($get_from, $bus_way);
            $data_bus_end_way = array_search($get_to, $bus_way);

            return ($data_bus_start_way && $data_bus_end_way) ? ($data_bus_start_way < $data_bus_end_way) ? true : false : false;

        }

        //проверка на наличие прямого/обратного маршрута
        public function data_check_path(int $get_from, int $get_to) : array {
            
            $data_bus_has_way = ($this -> data_finde_way($get_from, $get_to, $this -> data_route_first_way) or 
                                  $this -> data_finde_way($get_from, $get_to, $this -> data_route_second_way)) ? true : false;

            if($data_bus_has_way){ 
                
                return ($this -> data_finde_way($get_from, $get_to, $this -> data_route_first_way)) ? $this -> data_route_first_way : $this -> data_route_second_way; 
            
            } 
            
            return [];

        }

        //получаем массив с веменем необходимого маршрута
        private function data_get_way_time(array $data_bus_path) : array {
             
            return ($data_bus_path == $this -> data_route_first_way) ? $this -> data_time_first_way : $this -> data_time_second_way; 

        }

        //среднее время затрачиваемое на проезд между остановками на маршруте
        protected function data_average_time_betwin_stop(array $data_time_first_way, array $data_time_second_way, array $data_route_first_way) : int {

            $data_number_route_stops = count($data_route_first_way);

            $data_interval = $data_time_second_way[0] -> diff($data_time_first_way[0]);

            return ($data_interval -> h * 60 + $data_interval -> i) / $data_number_route_stops;

        }

        //изменение времени в связи с начальной остановкой
        private function data_add_average_difference(array &$data_time_way, int $get_from, array $data_path_array) : void {
            
            $data_stops_until_required = array_search($get_from, $data_path_array);
            $data_average = $this -> data_average_time_betwin_stop($this -> data_time_first_way, $this -> data_time_second_way, $this -> data_route_first_way) * $data_stops_until_required;
            
            foreach($data_time_way as $data_time){

                $data_time -> modify('+'. $data_average . ' minutes');

            }

        }

        //получение 3 ближайших по времени маршрута
        private function data_approximate_time (int $get_from, int $get_to) : array {

            $data_suitable_index; 
            $data_appropriate_time;

            $data_path_array = $this -> data_check_path($get_from, $get_to);
            
            $data_time_way = $this -> data_get_way_time($data_path_array);

            $this -> data_add_average_difference($data_time_way, $get_from, $data_path_array);

            $data_time_now = new DateTime(date('H:i'));

            for($index = 0; $index < count($data_time_way); $index++){
                                
                if($data_time_now < $data_time_way[$index]){

                    $data_suitable_index = $index;
                    break;

                }

            }

            for ($index = 0; $index < 3; $index++){

                if(!$data_time_way[$data_suitable_index + $index]) break;
                $data_appropriate_time[] = ($data_time_way[$data_suitable_index + $index]);

            }
            
            return $data_appropriate_time;

        }

        //собираем данные об автобусе
        public function get_data(array $index_stop, int $get_from, int $get_to, array $index_bus_path) : array {
            
            return  [

                        'route' => $this -> data_bus_name . ' в сторону ост. ' . $index_stop[array_search(end($index_bus_path), $index_bus_path)],
                        'next_arrivals' => $this -> data_approximate_time ($get_from, $get_to)
                    
                    ];

        }

    }