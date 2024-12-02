<?php

    class Bus{
        
        private string $bus_name;
        private array $bus_names_admin;

        public function set_bus_name(string $index_bus_name) : object {

            $this -> bus_name = $index_bus_name;
            return $this;

        }

        public function get_bus_name() : string {

            return $this -> bus_name;

        }

        public function add_bus_names_admin(string $admin_bus_name) : void {

            $this -> bus_names_admin[] = $admin_bus_name;

        }

        public function get_bus_names_admin() : array {

            return $this -> bus_names_admin;

        }
    }
    