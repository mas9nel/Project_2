<?php 

    include_once('index.php');
    include_once('technical.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Автобусы</title>
</head>
<body>

    <!-- выбор начальной/конечной остановки main -->
    <form method="GET" action="visualization.php">
       
        Откуда: 
       <select name="visualization_from">

           <?php technical_visu_output($index_stop -> stop_get()); ?>

       </select>
        
       Куда: 
       <select name="visualization_to">

           <?php technical_visu_output($index_stop -> stop_get()); ?>

       </select>

       <input type="submit" class="button" value="Подтвердить">

    </form>

    <hr>

    <?php
    
        print_r($index_data -> data_jsone_get());
        print('<hr>'); 
        print_r(json_decode($index_data -> data_jsone_get()));
    
    ?>

</body>
</html>