<?php

require_once('src/helpers.php');
require_once('src/function.php');
require_once('src/db.php');
/* @var mysqli $mysql */

$is_auth = rand(0, 1);
$user_name = 'Владик';

$postId = request_retriveGetInt('post-id', 0);

/**
 * Проверяем существует ли пост
 * @param mysqli $connection параметры соединения с sql
 * @param int $postId отвалидированное значение int
 * @return bool True если пост существует и false если нет
 */
function isPostExist(mysqli $connection, int $postId): bool
{
    if ($connection == false) {
        print ("Ошибка подключения: ".mysqli_connect_error());
    } else {
        $truePost = "
SELECT
    post.id
FROM
    post
WHERE
    post.id = $postId
    ";

        $truePostResult = mysqli_query($connection, $truePost);
        $postId = mysqli_fetch_all($truePostResult, MYSQLI_ASSOC);
    };
    if (empty($postId) == true) {
        return false;
    } else {
        return true;
    }
}

$postIdExist = isPostExist($mysql, $postId);


$post_id = $postId;


/**
 * Массив, в который мы вкладываем ВСЕ данные о посте
 */
$postDetails = array();

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
WHERE  post.id = ?
    ";
    $postPrepare = db_get_prepare_stmt($mysql, $post, $data = [$postId]);
    $postPrepareRes = mysqli_stmt_get_result($postPrepare);
    $postResultRows = mysqli_fetch_all($postPrepareRes, MYSQLI_ASSOC);
    $postDetails = getInfo($postResultRows, $postDetails, 'main-content');
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
WHERE  post.id = ?
GROUP BY post.id
    ";
    $additionalContentPrepare = db_get_prepare_stmt($mysql, $additionalContent, $data = [$postId]);
    $additionalContentPrepareRes = mysqli_stmt_get_result($additionalContentPrepare);
    $additionalContentResultRows = mysqli_fetch_all($additionalContentPrepareRes, MYSQLI_ASSOC);
    $postDetails = getInfo($additionalContentResultRows, $postDetails, 'author-info');
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

WHERE  post.id = ?
    ";
    $like_countPrepare = db_get_prepare_stmt($mysql, $like_count, $data = [$postId]);
    $like_countPrepareRes = mysqli_stmt_get_result($like_countPrepare);
    $like_countResultRows = mysqli_fetch_all($like_countPrepareRes, MYSQLI_ASSOC);
    $postDetails = getInfo($like_countResultRows, $postDetails, 'like-count');
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

WHERE  post.id = ?
GROUP BY post.id
    ";
    $comment_countPrepare = db_get_prepare_stmt($mysql, $comment_count, $data = [$postId]);
    $comment_countPrepareRes = mysqli_stmt_get_result($comment_countPrepare);
    $comment_countResultRows = mysqli_fetch_all($comment_countPrepareRes, MYSQLI_ASSOC);
    $postDetails = getInfo($comment_countResultRows, $postDetails, 'comments&views-count');
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

WHERE  post.id = ?
    ";
    $userIDPrepare = db_get_prepare_stmt($mysql, $userID, $data = [$postId]);
    $userIDPrepareRes = mysqli_stmt_get_result($userIDPrepare);
    $userIDResultRows = mysqli_fetch_all($userIDPrepareRes, MYSQLI_ASSOC);
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
WHERE user_id = ?

    ";
    $subscribeCountPrepare = db_get_prepare_stmt($mysql, $subscribeCount, $data = [$authorID]);
    $subscribeCountPrepareRes = mysqli_stmt_get_result($subscribeCountPrepare);
    $subscribeCountResultRows = mysqli_fetch_all($subscribeCountPrepareRes, MYSQLI_ASSOC);
    $postDetails = getInfo($subscribeCountResultRows, $postDetails, 'authorPosts-count');
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
WHERE  post.id = ?
    ";
    $hashtagPrepare = db_get_prepare_stmt($mysql, $hashtag, $data = [$post_id]);
    $hashtagPrepareRes = mysqli_stmt_get_result($hashtagPrepare);
    $hashtagResultRows = mysqli_fetch_all($hashtagPrepareRes, MYSQLI_ASSOC);
    $postDetails = getInfo($hashtagResultRows, $postDetails, 'hashtags');
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

WHERE  post.id = ?
ORDER BY comment.create_date ASC
LIMIT 2

    ";
    $commentPrepare = db_get_prepare_stmt($mysql, $comment, $data = [$post_id]);
    $commentPrepareRes = mysqli_stmt_get_result($commentPrepare);
    $commentResultRows = mysqli_fetch_all($commentPrepareRes, MYSQLI_ASSOC);
    $postDetails = getInfo($commentResultRows, $postDetails, 'comment-list');
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

WHERE  post.id = ?
GROUP BY post.id

    ";
    $comment_intPrepare = db_get_prepare_stmt($mysql, $comment_int, $data = [$post_id]);
    $comment_intPrepareRes = mysqli_stmt_get_result($comment_intPrepare);
    $comment_intResultRows = mysqli_fetch_all($comment_intPrepareRes, MYSQLI_ASSOC);
    $postDetails = getInfo($comment_intResultRows, $postDetails, 'comment-count');
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

WHERE  post.id = ?
ORDER BY comment.create_date ASC
    ";
    $noLimitCommentsPrepare = db_get_prepare_stmt($mysql, $noLimitComments, $data = [$post_id]);
    $noLimitCommentsPrepareRes = mysqli_stmt_get_result($noLimitCommentsPrepare);
    $noLimitCommentsResultRows = mysqli_fetch_all($noLimitCommentsPrepareRes, MYSQLI_ASSOC);
    $postDetails = getInfo($noLimitCommentsResultRows, $postDetails, 'comment-all-list');
};


/**
 * Подключаем шаблоны
 */

if ($postIdExist == false) {
    header("Location: Not-found.php");
} else {
    $post_content = include_template(
        'post.php',
        [
            'main_content' => $postDetails['main-content'],
            'author_info' => $postDetails['author-info'],
            'like_count' => $postDetails['like-count'],
            'comments_views_count' => $postDetails['comments&views-count'],
            'authorPosts_count' => $postDetails['authorPosts-count'],
            'hashtags' => $postDetails['hashtags'],
            'comment_list' => $postDetails['comment-list'],
            'comment_count' => $postDetails['comment-count'],
            'comment_all_list' => $postDetails['comment-all-list'],
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


    print ($layout_content);
}
