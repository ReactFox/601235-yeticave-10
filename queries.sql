USE yeticave_db;

#Существующий список категорий
INSERT INTO categories (category_title, symbolic_code)
VALUES ('Доски и лыжи', 'boards'),
       ('Крепления', 'attachment'),
       ('Ботинки', 'boots'),
       ('Одежда', 'clothing'),
       ('Инструменты', 'tools'),
       ('Разное', 'other');

# Добавляет пару пользователей
INSERT INTO users
SET date_registration = NOW(),
    email             = 'ivanow@mail.ru',
    user_name         = 'Иван',
    password          = 'secret1',
    contacts          = 'г. Москва, ул. Большая Лубянка, дом 2';

INSERT INTO users
SET date_registration = NOW(),
    email             = 'petrov@mail.ru',
    user_name         = 'Пётр',
    password          = 'secret2',
    contacts          = 'г. Москва, ул. Новая Площадь, дом 10';

# Существующий список объявлений
INSERT INTO lots (date_creation, lot_title, lot_description, lot_image, starting_price, date_finish, bet_step,
                  author_id, winner_id, category_id)
VALUES (NOW(), '2014 Rossignol District Snowboard', 'Прикольная доска', 'img/lot-1.jpg', 10999, '2019-08-19', 200,
        1,
        NULL, 1),
       (NOW(), 'DC Ply Mens 2016/2017 Snowboard', 'Просто комментарий для теста', 'img/lot-2.jpg', 15999,
        '2019-08-21', 300,
        2,
        NULL, 1),
       (NOW(), 'Крепления Union Contact Pro 2015 года размер L/XL', 'Текст комментария для креплений', 'img/lot-3.jpg',
        8000, '2019-08-21', 500,
        2,
        NULL, 2),
       (NOW(), 'Ботинки для сноуборда DC Mutiny Charocal', 'описание ботинок', 'img/lot-4.jpg', 10999, '2019-08-22',
        200,
        1,
        NULL, 3),
       (NOW(), 'Куртка для сноуборда DC Mutiny Charocal', 'Описание куртки', 'img/lot-5.jpg', 7500, '2019-08-28', 100,
        2,
        NULL, 4);

# Cделал одиночное добавление в лота в БД (для треникровки)
INSERT INTO lots
SET date_creation   = NOW(),
    lot_title       = 'Маска Oakley Canopy',
    lot_description = 'Описание для маски',
    lot_image       = 'img/lot-6.jpg',
    starting_price  = 5400,
    date_finish     = '2019-08-30',
    bet_step        = 50,
    author_id       = 1,
    winner_id       = NULL,
    category_id     = 6;

# Добавьте пару ставок для любого объявления
INSERT INTO bets
SET date_bet   = NOW(),
    bet_amouth = 100,
    user_id    = 1,
    lot_id     = 1;

INSERT INTO bets
SET date_bet   = NOW(),
    bet_amouth = 300,
    user_id    = 2,
    lot_id     = 1;

# получить все категории
SELECT category_title
FROM categories;

# получить самые новые, открытые лоты. Каждый лот должен включать название,
# стартовую цену, ссылку на изображение, цену, название категории;

SELECT lot_title, lot_image, starting_price, category_title
FROM lots l
         JOIN categories c ON l.category_id = c.id
WHERE date_finish > NOW()
ORDER BY date_creation DESC;


# показать лот по его id. Получите также название категории, к которой принадлежит лот;
SELECT *
FROM lots l
         JOIN categories c ON category_id = c.id
WHERE l.id = 3;

# обновить название лота по его идентификатору;
UPDATE lots
SET lot_title = 'Данные для обноления заголовка'
WHERE id = 4;

# получить список ставок для лота по его идентификатору с сортировкой по дате (Что значит по дате? от большего к меньшему?).
SELECT date_bet, lot_title, user_id, bet_amouth
FROM lots l
         JOIN bets b ON l.id = b.lot_id
WHERE l.id = 1
ORDER BY date_bet DESC;


#тестовая запись для поиска лота
SELECT l.id, lot_title, lot_description,lot_image, starting_price, category_title,date_finish
FROM lots l
         JOIN categories c ON l.category_id = c.id
WHERE MATCH(lot_title, lot_description) AGAINST('Куртка')
HAVING date_finish > NOW()
ORDER BY date_creation DESC;