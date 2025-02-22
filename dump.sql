-- таблица с наименованиями автобусов
CREATE TABLE buses (bus_id SERIAL PRIMARY KEY, bus_name CHARACTER VARYING(100));

INSERT INTO buses (bus_name) 
VALUES ('Маршрут №1'), ('Маршрут №2'), ('Маршрут №3'), ('Маршрут №4'), ('Маршрут №5'), ('Маршрут №6'); 

-- таблица с маршрутами
CREATE TABLE routes (route_id SERIAL PRIMARY KEY, route_first_way CHARACTER VARYING(200), route_second_way CHARACTER VARYING(200));

INSERT INTO routes (route_first_way, route_second_way)
VALUES ('3,5,4,8,17', '17,8,4,5,3'), 
       ('15,10,8,4,2', '2,7,9,11,15'), 
       ('20,13,15,7,9,11,5,7', '7,3,17,5,4,2,1'), 
       ('1,2,3,4,5,6,7,8,9,10,11', '11,12,13,14,15,16,17,18,19,20'), 
       ('3,5,6,7,8,9', '9,2,3,15,17,8'), 
       ('5,10,15,13,7,4', '1,2,3,5,6,7,9,10,11');

-- таблица с временем
CREATE TABLE time_route (time_id SERIAL PRIMARY KEY, time_first_way CHARACTER VARYING(250), time_second_way CHARACTER VARYING(250));

INSERT INTO time_route (time_first_way, time_second_way)
VALUES ('6:00, 6:30, 7:00, 7:30, 8:00, 8:30, 9:00, 9:30, 10:00, 10:30, 11:00, 11:30, 12:00', '6:25, 6:55, 7:25, 7:55, 8:25, 8:55, 9:25, 9:55, 10:25, 10:55, 11:25, 11:55, 12:25'), 
       ('6:00, 7:00, 8:00, 9:00, 10:00, 11:00, 12:00, 13:00, 14:00, 15:00, 16:00, 17:00, 18:00, 19:00, 20:00', '6:50, 7:50, 8:50, 9:50, 10:50, 11:50, 12:50, 13:50, 14:50, 15:50, 16:50, 17:50, 18:50, 19:50, 20:50'), 
       ('6:00, 7:00, 8:00, 9:00, 10:00, 11:00, 12:00, 13:00, 14:00, 15:00, 16:00, 17:00, 18:00, 19:00, 20:00, 21:00,22:00', '6:50, 7:50, 8:50, 9:50, 10:50, 11:50, 12:50, 13:50, 14:50, 15:50, 16:50, 17:50, 18:50, 19:50, 20:50, 21:50, 22:50'), 
       ('6:00, 7:00, 8:00, 9:00, 10:00, 11:00, 12:00, 13:00, 14:00, 15:00, 16:00, 17:00, 18:00, 19:00, 20:00', '7:10, 8:10, 9:10, 10:10, 11:10, 12:10, 13:10, 14:10, 15:10, 16:10, 17:10, 18:10, 19:10, 20:10, 21:10'), 
       ('7:10, 8:10, 9:10, 10:10, 11:10, 12:10, 13:10, 14:10, 15:10, 16:10, 17:10, 18:10, 19:10, 20:10, 21:10', '6:00, 7:00, 8:00, 9:00, 10:00, 11:00, 12:00, 13:00, 14:00, 15:00, 16:00, 17:00, 18:00, 19:00, 20:00'), 
       ('6:15, 7:15, 8:15, 9:15, 10:15, 11:15, 12:15, 13:15, 14:15, 15:15, 16:15, 17:15, 18:15, 19:15, 20:15', '7:00, 8:00, 9:00, 10:00, 11:00, 12:00, 13:00, 14:00, 15:00, 16:00, 17:00, 18:00, 19:00, 20:00, 21:00');

-- таблица с остановками
CREATE TABLE stop (stop_id SERIAL PRIMARY KEY, stop_name CHARACTER VARYING(150));

INSERT INTO stop (stop_name) 
VALUES ('Пушкина'), ('Ленина'), ('Гоголя'), ('Шевченко'), ('Лермонтова'), ('Королева')
       ('Толстого'), ('Чехова'), ('Маяковского'), ('Достоевского'), ('Менделеева'),
       ('Павлова'), ('Ломоносова'), ('Невского'), ('Кутузова'), ('Жукова'), 
       ('Чайковского'), ('Шостаковича'), ('Высоцкого'), ('Стачек'); 