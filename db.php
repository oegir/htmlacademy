<?php

/**
 *
 * Подключили БД
 *
 */
$mysql = mysqli_connect("localhost", "root", "", "readme");
mysqli_set_charset($mysql, "utf8");
if ($mysql == false) {
    print ("Ошибка подключения: ".mysqli_connect_error());
} else {
    $postList = "
SELECT
       `name`, `text_content`,`header`,`create_date`,`avatar`, `icon_name`,`media`
FROM
     post
         LEFT JOIN
         user ON post.user_id = user.id
         LEFT JOIN content_type ON content_type.id = content_type_id
ORDER BY `views_number` DESC";


    $postListResult = mysqli_query($mysql, $postList);
    $postListRows = mysqli_fetch_all($postListResult, MYSQLI_ASSOC);
};
