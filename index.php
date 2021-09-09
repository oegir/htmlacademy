<?php

require_once('helpers.php');
require_once('function.php');
require_once('db.php');

$is_auth = rand(0, 1);
$user_name = 'Владик';


/**
 * Фильтры
 */
$content_type_id = retriveGetString('content_type', 'all');
if ($content_type_id == 'all') {
    $content_type_id = ('1,2,3,4,5');
}

$sort_id = retriveGetString('sort', 'popular');
if ($sort_id == 'popular') {
    $sort_id = ('views_number');
} elseif ($sort_id == 'date') {
    $sort_id = ('create_date');
} elseif ($sort_id = 'like_count') {
    $sort_id = ('like_count.post_id');
};

/**
 * Условие загрузки страницы
 * в if загружается страница поста
 * в else загрузится список постов на главной странице
 */


if (array_key_first($_GET) == 'post-id') {
    $post_id = filter_input(INPUT_GET, 'post-id');
    /**
     * Запрос для проверки существования id поста в БД
     */
    if ($mysql == false) {
        print ("Ошибка подключения: ".mysqli_connect_error());
    } else {
        $truePost = "
    SELECT
    post.id AS `post_num`
    FROM
  post
WHERE  post.id = $post_id
    ";

        $truePostResult = mysqli_query($mysql, $truePost);
        $truePostResultRows = mysqli_fetch_all($truePostResult, MYSQLI_ASSOC);
    };


    /**
     * Подключаем бд для страницы поста, главный контент
     */

    if ($mysql == false) {
        print ("Ошибка подключения: ".mysqli_connect_error());
    } else {
        $post = "
SELECT
    post.id AS `post_num`, post.text_content as `text`,post.header AS `header`,post.media AS `media`,
       post.author_copy_right AS `author_copy_right`, content_type.icon_name AS `icon_name`


FROM
    post
        LEFT JOIN
        user ON user.id = post.user_id
        LEFT JOIN
        content_type ON content_type.id = post.content_type_id
WHERE  post.id = $post_id
    ";

        $postResult = mysqli_query($mysql, $post);
        $postRows = mysqli_fetch_all($postResult, MYSQLI_ASSOC);
    };

    /**
     * Запрос на информацию об авторе
     */

    if ($mysql == false) {
        print ("Ошибка подключения: ".mysqli_connect_error());
    } else {
        $additionalContent = "
SELECT
     user.reg_date AS `reg_date`, user.name AS `name`, user.avatar AS `avatar`, count(subscribe.user_subscribe_id) AS `subscribe-count`,
       count(like_count.post_id) AS `like-count`

FROM
    post
        LEFT JOIN
        user ON user.id = post.user_id
        LEFT JOIN
        content_type ON content_type.id = post.content_type_id
        LEFT JOIN
        subscribe ON user_author_id = post.user_id
        LEFT JOIN
          like_count ON like_count.post_id = post.id
WHERE  post.id = $post_id AND subscribe.user_author_id = post.user_id
    ";

        $additionalContentResult = mysqli_query($mysql, $additionalContent);
        $additionalContentResultRows = mysqli_fetch_all($additionalContentResult, MYSQLI_ASSOC);
    };

    /**
     * Запрос на кол-во лайков
     */

    if ($mysql == false) {
        print ("Ошибка подключения: ".mysqli_connect_error());
    } else {
        $like_count = "
SELECT
   count(like_count.post_id) AS `like-count`

FROM
  post

    LEFT JOIN
  like_count ON like_count.post_id = post.id

WHERE  post.id = $post_id
    ";
        $like_countResult = mysqli_query($mysql, $like_count);
        $like_countResultRows = mysqli_fetch_all($like_countResult, MYSQLI_ASSOC);
    }

    /**
     * Запрос на кол-во комментариев и просмотров
     */

    if ($mysql == false) {
        print ("Ошибка подключения: ".mysqli_connect_error());
    } else {
        $comment_count = "
SELECT
    count(comment.id) AS `comment-count`, post.views_number AS `views`

FROM
  post
    LEFT JOIN
      comment ON comment.post_id = post.id
WHERE  post.id = $post_id
    ";
        $comment_countResult = mysqli_query($mysql, $comment_count);
        $comment_countResultRows = mysqli_fetch_all($comment_countResult, MYSQLI_ASSOC);
    }

    /**
     * узнаем id автора для проверки кол-ва постов
     */

    if ($mysql == false) {
        print ("Ошибка подключения: ".mysqli_connect_error());
    } else {
        $userID = "
SELECT
     post.user_id
FROM
    post

WHERE  post.id = $post_id
    ";
        $userIDResult = mysqli_query($mysql, $userID);
        $userIDResultRows = mysqli_fetch_all($userIDResult, MYSQLI_ASSOC);
    };
    $authorArray = array_pop($userIDResultRows);
    $authorID = array_pop($authorArray);

    /**
     * узнаем кол-во постов у автора
     */

    if ($mysql == false) {
        print ("Ошибка подключения: ".mysqli_connect_error());
    } else {
        $subscribeCount = "
SELECT
       count(post.id) AS `publication_count`
FROM
  post
    LEFT JOIN
  user ON user.id = post.user_id
WHERE user_id = $authorID


    ";
        $subscribeCountResult = mysqli_query($mysql, $subscribeCount);
        $subscribeCountResultRows = mysqli_fetch_all($subscribeCountResult, MYSQLI_ASSOC);
    }

    /**
     * Запрос на Хештеги
     */

    if ($mysql == false) {
        print ("Ошибка подключения: ".mysqli_connect_error());
    } else {
        $hashtag = "
SELECT
     post.id AS `post_num`, hashtag.hashtag_name AS `hs-name`

FROM
    post
LEFT JOIN
        hashtag_post ON hashtag_post.post = post.id
LEFT JOIN
        hashtag ON hashtag.id = hashtag_post.hashtag
WHERE  post.id = $post_id
    ";

        $hashtagResult = mysqli_query($mysql, $hashtag);
        $hashtagResultRows = mysqli_fetch_all($hashtagResult, MYSQLI_ASSOC);
    };

    /**
     * запрос на список комментариев
     */

    if ($mysql == false) {
        print ("Ошибка подключения: ".mysqli_connect_error());
    } else {
        $comment = "
SELECT
     post.id AS `post_num`, comment.create_date AS `date`, comment.content AS `comment`, user.name AS `name`, user.avatar AS `avatar`

FROM
    post

LEFT JOIN
        comment ON comment.post_id = post.id

LEFT JOIN
        user ON user.id = comment.user_id

WHERE  post.id = $post_id
ORDER BY comment.create_date ASC
LIMIT 2

    ";

        $commentResult = mysqli_query($mysql, $comment);
        $commentResultRows = mysqli_fetch_all($commentResult, MYSQLI_ASSOC);
    };

    /**
     * число комментариев под списком комментариев
     */

    if ($mysql == false) {
        print ("Ошибка подключения: ".mysqli_connect_error());
    } else {
        $comment_int = "
SELECT
  post.id AS `post_num`, count(comment.id) AS `comment-count`

FROM
  post

    LEFT JOIN
  comment ON comment.post_id = post.id

    LEFT JOIN
  user ON user.id = comment.user_id

WHERE  post.id = $post_id

    ";

        $comment_intResult = mysqli_query($mysql, $comment_int);
        $comment_intResultRows = mysqli_fetch_all($comment_intResult, MYSQLI_ASSOC);
    };

    /**
     * Список комментариев после второго
     */

    if ($mysql == false) {
        print ("Ошибка подключения: ".mysqli_connect_error());
    } else {
        $noLimitComments = "
SELECT
     post.id AS `post_num`, comment.create_date AS `date`, comment.content AS `comment`, user.name AS `name`, user.avatar AS `avatar`

FROM
    post

LEFT JOIN
        comment ON comment.post_id = post.id

LEFT JOIN
        user ON user.id = comment.user_id

WHERE  post.id = $post_id
ORDER BY comment.create_date ASC
    ";
        $noLimitCommentsResult = mysqli_query($mysql, $noLimitComments);
        $noLimitCommentsResultRows = mysqli_fetch_all($noLimitCommentsResult, MYSQLI_ASSOC);
    };

    /**
     * Подключаем шаблоны
     */

    $post_content = include_template(
        '../post.php',
        [
            'truePostResultRows' => $truePostResultRows,
            'postRows' => $postRows,
            'additionalContentResultRows' => $additionalContentResultRows,
            'subscribeCountResultRows' => $subscribeCountResultRows,
            'like_countResultRows' => $like_countResultRows,
            'comment_countResultRows' => $comment_countResultRows,
            'hashtagResultRows' => $hashtagResultRows,
            'commentResultRows' => $commentResultRows,
            'comment_intResultRows' => $comment_intResultRows,
            'noLimitCommentsResultRows' => $noLimitCommentsResultRows,


        ]
    );
    $layout_content = include_template(
        'layout.php',
        [

            'content' => $post_content,
            'is_auth' => $is_auth,
            'user_name' => $user_name,
            'title' => 'readme: публикация',

        ]
    );
} else {
    /**
     * подключили таблицу постов из бд
     */

    if ($mysql == false) {
        print ("Ошибка подключения: ".mysqli_connect_error());
    } else {
        $postList = "
SELECT
       post.id AS `post_num`, post.text_content AS `text_content`,post.header AS `header`, post.create_date AS `create_date`,
       post.media AS `media`,user.avatar AS `avatar`,user.name AS `name`, content_type.icon_name AS `icon_name`,  count(like_count.id) AS `like-count`,
  count(comment.id) AS `comment-count`

FROM
     post

         LEFT JOIN
         user ON user.id = post.user_id
         LEFT JOIN
         content_type ON content_type.id = post.content_type_id
        LEFT JOIN
         like_count ON like_count.post_id = post.id
        LEFT JOIN
       comment  ON comment.post_id = post.id

WHERE content_type.id IN ($content_type_id)
GROUP BY post.id
ORDER BY $sort_id DESC";


        $postListResult = mysqli_query($mysql, $postList);
        $postListRows = mysqli_fetch_all($postListResult, MYSQLI_ASSOC);
    };

    /**
     * Подключаем шаблоны
     */

    $page_content = include_template(
        'main.php',
        [
            'postListRows' => $postListRows,


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
}

print($layout_content);

?>

