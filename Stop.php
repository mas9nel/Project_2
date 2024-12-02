<?php

    class Stop{

        private array $stop_place;

        public function stop_set(string $main_stop) : void { 
        
            $this -> stop_place[] = $main_stop; 
        
        }

        public function stop_get() : array { 
        
            return $this -> stop_place; 
        
        }

    }