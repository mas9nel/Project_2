<?php

    include_once('technical.php');

    class Route{
        
        private array $route_first_way;
        private array $route_second_way;


        public function set_first_way(string $index_first_way) : object {

            $this -> route_first_way = technical_str_to_array($index_first_way);
            return $this;

        }

        public function set_second_way(string $index_second_way) : object {

            $this -> route_second_way = technical_str_to_array($index_second_way);
            return $this;

        }

        public function get_first_way() : array {

            return $this -> route_first_way;

        }

        public function get_second_way() : array {

            return $this -> route_second_way;

        }

    }