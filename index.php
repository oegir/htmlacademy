<?php
require_once('src/helpers.php');
require_once('src/db.php');

$is_auth = rand(0, 1);
$user_name = 'Андрей';

$mysql = dbGetConnection();
$postList = "
SELECT
    `name`, `text_content`,`header`,`create_date`,`avatar`, `icon_name`,`media`
FROM
    post
LEFT JOIN
    user ON post.user_id = user.id
LEFT JOIN
    content_type ON content_type.id = content_type_id
ORDER BY
    `views_number` DESC";
$postListResult = mysqli_query($mysql, $postList);
$postListRows = mysqli_fetch_all($postListResult, MYSQLI_ASSOC);

/**
 * Подключаем шаблоны
 */
$page_content = include_template('main.php', [
    'postListRows' => $postListRows
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => 'readme: популярное'
]);
print($layout_content);

/**
 * Ограничение кол-ва символов в посте (не больше лимита)
 *
 * @param string $text Оригинальный текст
 * @param int $limit кол-во символов для ограничения
 * @param string $url ссылка (пока не используется)
 *
 * @return string возвращаем текст с кол-вом символов не больше лимита
 */
function cutText(string $text, int $limit = 300, string $url = '#'): string
{
    // превращаем исходный текст в массив слов
    $words = explode(' ', $text);
    // результат работы выводим в новый массив
    $result = [];
    //изначально ссылка будет пустой
    $link = '';
    // если длина текста больше лимита
    if (mb_strlen($text) > $limit) {
        $symbols = 0;
        foreach ($words as $word) {
            //подсчитываем сколько слов в каждом элементе массива + пробел
            $symbols += mb_strlen($word) + 1;
            //многоточие тоже символ, берем расчет и на них
            if ($symbols + 3 < $limit) {
                $result[] = $word;
            } else {
                break;
            }
        }
        //добавляем многоточия в массив
        $ellipsis = ('...');
        $result[] = $ellipsis;
        //добавляем ссылку
        $link = '<a class="post-text__more-link" href="#">Читать далее</a>';
        //если слов меньше лимита
    } else {
        $result = $words;
    }

    return '<p>'.implode(' ', $result).'</p>'.$link;
}

/**
 * отображение даты на странице
 *
 * @param $date string дата из бд
 * @return string дата в формате d-m-Y H:i
 * @throws Exception преобразование строки в дататайм
 *
 */
function cutdate($date)
{
    $postDate = new DateTimeImmutable($date);
    $cutDate = $postDate->format('d-m-Y H:i');
    return $cutDate;
}


/**
 * отображение даты на странице
 *
 * @param $date string дата из бд
 * @return string дата в формате d-m-Y H:i:s
 * @throws Exception преобразование строки в дататайм
 *
 */
function fullDate($date)
{
    $postDate = new DateTimeImmutable($date);
    $fullDate = $postDate->format('d-m-Y H:i:s');
    return $fullDate;
}

/**
 * отображение даты на странице
 *
 * @param $date string дата из бд
 * @return string Дата в формате был * назад
 * @throws Exception преобразование строки в дататайм
 *        
 */
function smallDate($date)
{
    $postDate = new DateTimeImmutable($date);
    // вычисляем разницу между серверным временем и датой поста
    $nowDate = new DateTimeImmutable();
    $difference = $nowDate->diff($postDate);

    if ($difference->m > 0) {
        $resultForPost = get_noun_plural_form($difference->m, 'месяц', 'месяца', 'месяцев');
        $smallDate = "$difference->m $resultForPost назад";
    } elseif (intdiv($difference->d, 7) > 0) {
        $weeks = intdiv($difference->d, 7);
        $resultForPost = get_noun_plural_form($weeks, 'неделя', 'недели', 'недель');
        $smallDate = "$weeks $resultForPost назад";
    } elseif ($difference->d > 0) {
        $resultForPost = get_noun_plural_form($difference->d, 'день', 'дня', 'дней');
        $smallDate = "$difference->d $resultForPost назад";
    } elseif ($difference->h > 0) {
        $resultForPost = get_noun_plural_form($difference->h, 'час', 'часа', 'часов');
        $smallDate = "$difference->h $resultForPost назад";
    } else {
        $resultForPost = get_noun_plural_form($difference->i, 'минута', 'минуты', 'минут');
        $smallDate = "$difference->i $resultForPost назад";
    }
    return $smallDate;
}
