<?php

require_once('src/helpers.php');
require_once('src/function.php');
require_once('src/db.php');
/* @var mysqli $mysql */
$is_auth = rand(0, 1);
$user_name = 'Владик';


/**
 * Фильтры
 */
$content_type_id = request_retriveGetString('content_type', 'all');
$trueContent_type = trueContent_type_id($content_type_id);

$sort_id = request_retriveGetString('sort', 'popular');
$trueSort_id = trueSortId($sort_id);
/**
 * Считаем сколько знаков ? Необходимо для sql запроса
 */
$in = str_repeat('?,', count($trueContent_type) - 1).'?';

/**
 * подключили таблицу постов из бд
 */

if ($mysql == false) {
    print ("Ошибка подключения: ".mysqli_connect_error());
} else {
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
WHERE content_type.id IN ($in)
ORDER BY $trueSort_id DESC
";

    $postListPrepare = db_get_prepare_stmt(
        $mysql,
        $postList,
        $data = $trueContent_type
    );

    $postListPrepareRes = mysqli_stmt_get_result($postListPrepare);
    $postListRows = mysqli_fetch_all($postListPrepareRes, MYSQLI_ASSOC);
};

/**
 * Подключаем шаблоны
 */
$post_content = include_template(
    'block/block_post.php',
    [
        'postListRows' => $postListRows,

    ]
);

$page_content = include_template(
    'main.php',
    [
        'post_content' => $post_content,

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

?>

