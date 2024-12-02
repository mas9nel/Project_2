<?php

    include_once('technical.php');

    class Time{
        
        private array $time_first_way;
        private array $time_second_way;

        //время из массива
        private function array_to_time(array $str_time) : array {
            
            $time_array = [];

            foreach($str_time as $time_obj){

                $hours_minutes = technical_str_to_array($time_obj, ':');

                $time_array[] = (new DateTime()) -> setTime($hours_minutes[0], $hours_minutes[1]);

            }

            return $time_array;

        }

        public function set_time_first_way(string $index_time_first_way) : object {

            $this -> time_first_way = $this -> array_to_time(technical_str_to_array($index_time_first_way));
            return $this;

        }

        public function set_time_second_way (string $index_time_second_way) : object {

            $this -> time_second_way = $this -> array_to_time (technical_str_to_array($index_time_second_way));
            return  $this;

        }

        public function get_time_first_way() : array {

            return $this -> time_first_way;

        }

        public function get_time_second_way() : array {

            return $this -> time_second_way;

        }

    }