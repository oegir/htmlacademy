USE readme;
/*
 Список типов контента для поста
 */
INSERT INTO `content_type` (type_name, icon_name) VALUES ('текст', 'text'), ('Цитата', 'quote'), ('Картинка', 'photo'), ('Видео', 'video'), ('Ссылка', 'link');
/*
 Пара пользователей
 */
INSERT INTO `user` (reg_date, email, login, password, name , avatar) VALUES ('2015.05.05', 'firstemail@mail.ru', 'Вася', 'qwerty', 'Вася', 'somelink.ru'), ('2015.05.06', 'secondemail@mail.ru', 'Петр', 'somehardpass', 'Петр', 'somelink.ru'), ('2015.05.05', 'larisa@mail.ru', 'Лариса', 'qwerty', 'Лариса', 'somelink.ru'), ('2015.05.05', 'Vladikemail@mail.ru', 'Владик', 'qwerty', 'Владик', 'somelink.ru'), ('2015.05.05', 'Victoremail@mail.ru', 'Виктор', 'qwerty', 'Виктор', 'somelink.ru');
/*
 Все посты
 */
INSERT INTO `post` (create_date, header, text_content, author_copy_right, media, views_number, user_id, content_type_id) VALUES ('2020.08.23', 'Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих','Сергей Есенин','somelink.com', '5','3', '2'), ('2020.07.23', 'Игра престолов', 'Не могу дождаться начала финального сезона своего любимого сериала!', '', '', '10', '4', '1'), ('2020.07.28', 'Наконец, обработал фотки!', '','','img.link', '15','5','3'), ('2020.08.20', 'Моя мечта', '','','img1.link', '25','3','3'), ('2020.08.23', 'Лучшие курсы', 'Лучшие курсы','','www.htmlacademy.ru','25','3','2');
/*
 Пара комментариев
 */
INSERT INTO `comment` (create_date, content, user_id, post_id) VALUES ('2020.08.23', 'Первый!', '1', '2'), ('2020.08.23', 'Как же скучно', '2', '1');
/*
 получаем список постов с сортировкой по популярности и вместе с именами авторов и типом контента
 */
SELECT `views_number`, `name`,`content_type_id` FROM `post` LEFT JOIN `user` ON post.user_id = user.id ORDER BY `views_number` DESC;
/*
 получить список постов для конкретного пользователя
 */
SELECT `id` FROM `post`  WHERE `user_id` = 3;
/*
 получить список комментариев для одного поста, в комментариях должен быть логин пользователя;
 */
SELECT `login`, `content` FROM `comment` INNER JOIN `user` ON comment.user_id = user.id WHERE post_id = 2;
/*
 добавить лайк к посту;
 */
INSERT INTO `like_count`  (user_id, post_id) VALUES ('1', '2');
/*
 подписаться на пользователя
 */
INSERT INTO `subscribe` (user_subscribe_id, user_author_id) VALUES ('1', '3');
