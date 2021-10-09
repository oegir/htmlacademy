<?php

define('SORT_VIEWS', 'views_number');
define('SORT_DATE', 'create_date');
define('SORT_LIKES', 'count_likes');

define('TYPE_TEXT', 'text');
define('TYPE_QUOTE', 'quote');
define('TYPE_PHOTO', 'photo');
define('TYPE_VIDEO', 'video');
define('TYPE_LINK', 'link');

require_once('src/helpers.php');
require_once('src/function.php');
require_once('src/request.php');
require_once('src/db.php');
/* @var mysqli $mysql */
/*
 * Входящие данные
 */

$is_auth = rand(0, 1);
$user_name = 'Владик';

$content_type = request_retriveGetInt('content_type', null);
$sort_id = getSortId();

/**
 * Отображение данных
 */
$post_content = include_template(
    'block/block_post.php',
    [
        'postListRows' => findPosts($mysql, $sort_id, $content_type),
    ]
);

$page_content = include_template(
    'main.php',
    [
        'sort' => $sort_id,
        'current_type' => $content_type,
        'post_content' => $post_content,
        'content_types' => getContentTypes($mysql, 'type_name'),
    ]
);

$layout_content = include_template(
    'layout.php',
    [
        'content' => $page_content,
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'title' => 'readme: популярное',
    ]
);

print($layout_content);

/*
 * Обработка данных
 */

/**
 * Get posts from database according to the search conditions
 */
function findPosts(mysqli $mysql, string $sortId, ?int $typeId, int $offset = 0, int $limit = 9): array
{
    $where = '';
    $data = [];
    // Считаем сколько знаков ? Необходимо для sql запроса
    if (! is_null($typeId)) {
        $where = "WHERE content_type.id = ?";
        $data[] = $typeId;
    }
    // подключили таблицу постов из бд
    $postList = "
SELECT
  post.id AS `post_num`, post.text_content AS `text_content`,post.header AS `header`, post.create_date AS `create_date`,
  post.media AS `media`,user.avatar AS `avatar`,user.name AS `name`, content_type.icon_name AS `icon_name`, count_comments, count_likes
FROM
  post
LEFT JOIN
  user ON user.id = post.user_id
LEFT JOIN
  content_type ON content_type.id = post.content_type_id
LEFT JOIN (
    SELECT
      post_id, count(post_id) AS count_comments
    FROM
      comment
    GROUP BY post_id
    ) AS c ON c.post_id = post.id
    LEFT JOIN (
    SELECT
      post_id, count(post_id) AS count_likes
    FROM
      like_count
    GROUP BY post_id
  ) AS l ON l.post_id = post.id
$where
ORDER BY $sortId DESC
LIMIT $offset, $limit
";
    
    $postListPrepare = db_get_prepare_stmt(
        $mysql,
        $postList,
        $data
    );
    
    $postListPrepareRes = mysqli_stmt_get_result($postListPrepare);
    return mysqli_fetch_all($postListPrepareRes, MYSQLI_ASSOC);
}

/**
 * Retrive content types data
 * @param string $index result set indexing column
 */
function getContentTypes(mysqli $mysql, string $index = null): array
{
    $query = 'SELECT id, type_name, icon_name FROM content_type';
    $postListPrepare = db_get_prepare_stmt($mysql, $query);
    
    $rows = mysqli_stmt_get_result($postListPrepare);
    $result = [];
    
    if (! is_null($index)) {
        
        foreach ($rows as $item) {
            $result[$item[$index]] = $item;
        }
    } else {
        $result = $rows;
    }
    
    return $result;
}

/**
 * Выражение для вставки Сортировки в sql запрос
 * @param string $sort_id Сортировка из $_GET для фильтра на главной странице
 * @return string Сортировка для вставки в sql запрос
 */
function getSortId(): string
{
    $sort_id = request_retriveGetString('sort', SORT_LIKES);
    
    if (! in_array($sort_id, [SORT_VIEWS, SORT_DATE])) {
        $sort_id = SORT_LIKES;
    }
    
    return $sort_id;
}
