INSERT INTO category SET name = 'Доски и лыжи',
                         code = 'boardsandskis';

INSERT INTO category SET name = 'Крепления',
                         code = 'mounts';

INSERT INTO category SET name = 'Ботинки',
                         code = 'boots';

INSERT INTO category SET name = 'Одежда',
                         code = 'clothing';

INSERT INTO category SET name = 'Инструменты',
                         code = 'tools';

INSERT INTO category SET name = 'Разное',
                         code = 'other';


INSERT INTO user SET registration_date = '2021-03-20 10:00:00',
                     email = '1@eml.ru',
                     name = 'Alexandra',
                     password = 'password',
                     contacts = 'contacts';

INSERT INTO user SET registration_date = '2021-03-20 10:30:00',
                     email = '2@eml.ru',
                     name = 'Kristal',
                     password = 'password',
                     contacts = 'contacts';

INSERT INTO item SET date = '2021-03-20 12:00:00',
                     name = '2014 Rossignol District Snowboard',
                     description = '2014 Rossignol District Snowboard',
                     img_path = 'img/lot-1.jpg',
                     start_price = 10999,
                     completion_date = '2021-03-23',
                     bid_step = 100,
                     author_id = 1,
                     category_id = 1;

INSERT INTO item SET date = '2021-03-20 13:00:00',
                     name = 'DC Ply Mens 2016/2017 Snowboard',
                     description = 'DC Ply Mens 2016/2017 Snowboard',
                     img_path = 'img/lot-2.jpg',
                     start_price = 159999,
                     completion_date = '2021-03-24',
                     bid_step = 100,
                     author_id = 1,
                     category_id = 1;

INSERT INTO item SET date = '2021-03-20 15:00:00',
                     name = 'Крепления Union Contact Pro 2015 года размер L/XL',
                     description = 'Крепления Union Contact Pro 2015 года размер L/XL',
                     img_path = 'img/lot-3.jpg',
                     start_price = 8000,
                     completion_date = '2021-03-25',
                     bid_step = 100,
                     author_id = 2,
                     category_id = 2;

INSERT INTO item SET date = '2021-03-21 12:00:00',
                     name = 'Ботинки для сноуборда DC Mutiny Charocal',
                     description = 'Ботинки для сноуборда DC Mutiny Charocal',
                     img_path = 'img/lot-4.jpg',
                     start_price = 10999,
                     completion_date = '2021-03-26',
                     bid_step = 100,
                     author_id = 2,
                     category_id = 3;

INSERT INTO item SET date = '2021-03-21 14:00:00',
                     name = 'Куртка для сноуборда DC Mutiny Charocal',
                     description = 'Куртка для сноуборда DC Mutiny Charocal',
                     img_path = 'img/lot-5.jpg',
                     start_price = 7500,
                     completion_date = '2021-03-27',
                     bid_step = 100,
                     author_id = 1,
                     category_id = 4;

INSERT INTO item SET date = '2021-03-21 16:00:00',
                     name = 'Маска Oakley Canopy',
                     description = 'Маска Oakley Canopy',
                     img_path = 'img/lot-6.jpg',
                     start_price = 5400,
                     completion_date = '2021-05-12',
                     bid_step = 100,
                     author_id = 2,
                     category_id = 6;

INSERT INTO bid SET date = '2021-03-23 10:00:00',
                    price = 6000,
                    user_id = 1,
                    item_id = 6;

INSERT INTO bid SET date = '2021-03-23 15:00:00',
                    price = 6500,
                    user_id = 1,
                    item_id = 6;

