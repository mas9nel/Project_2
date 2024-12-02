<?php

    include_once('admin_visualization_reqest.php');
    include_once('technical.php');
    include_once('admin.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ</title>
</head>
<body>

<form method="Get" action="admin_visualization.php">
       
    <table>
        <td>

            Маршрут <br>
            <select name="admin_visualization_bus_name">

                <?php technical_visu_output($admin_bus -> get_bus_names_admin(), 1); ?>

            </select>

        </td>
        <td>

            Пр. направление/Обратное <br>
            <select name="admin_visualization_route">

                <?php technical_visu_output(['Прямое направление', 'Обратное'], 1); ?>

            </select>

        </td>
        <td>

            Удалить <br>
            <select name="admin_visualization_delete">

                <?php technical_visu_output(array_merge(['Ничего'], $admin_stop -> stop_get()),0,0); ?>

            </select>

        </td>
        <td>

            Добавить <br>
            <select name="admin_visualization_add">

                <?php technical_visu_output(array_merge(['Ничего'], $admin_stop -> stop_get()),0,0); ?>

            </select>

        </td>
        <td>

            <br>
            <input type="submit" class="button" value="Подтвердить">

        </td>

    </table>

    <hr>

</form>
    
</body>
</html>