<?php
    
    function technical_str_to_array(string $text, string $separator = ',') : array { 
        
        return explode($separator, trim($text));

    }

    function technical_array_to_string(array $text, string $separator = ',') : string { 
        
        return implode($separator, $text);

    }

    //вывод массива
    function technical_visu_output(array $array, int $correction_value = 0, int $correction_output = 1) : void { 

        for($index = 0; $index < count($array); $index++) echo '<option value=', ($index + $correction_value) , '>', ($index + $correction_output) , ' ' , $array[$index] ,'</option>'; 
        
    }