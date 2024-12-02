<?php

    class Data{

        private string $data_from;
        private string $data_to;
        private array $data_buses = [];

        public function __construct(string $index_from, string $index_to, array $stop){

            $this -> data_from = 'ул. ' . $stop[$index_from];
            $this -> data_to = 'ул. ' . $stop[$index_to];

        }

        //добавляем массив из Data_processing ( маршрут / время )
        public function data_add_bus(array $index_data_buses) : void {

            $this -> data_buses[] = $index_data_buses;

        }

        //сортировка массива по ближайшему времени
        private function data_sort_buses() : void {
            
            usort($this -> data_buses, function(array $data_first_bus_time, array $data_second_bus_time) :bool {

                return $data_first_bus_time['next_arrivals'][0] > $data_second_bus_time['next_arrivals'][0];

            });

            if(gettype($this -> data_buses[0]['next_arrivals'][0]) == 'string') return;

            foreach( $this->data_buses as &$data_buses_second_level ) {
                
                foreach($data_buses_second_level['next_arrivals'] as &$data_buses_third_level){
                        
                    $data_buses_third_level = $data_buses_third_level -> format('H:i');
                    
                }
            
            }
            
        }

        //получаем информацию
        private function data_get() : array {

            if(!$this -> data_buses[0]['next_arrivals'][0]) return [];

            $this -> data_sort_buses();

            return [

                        'from' => $this -> data_from,
                        'to' => $this -> data_to,
                        'buses' => $this -> data_buses

                   ];

        }

        //переводим в json
        public function data_jsone_get() {
            
            return json_encode($this -> data_get());

        }

    }