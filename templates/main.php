<div class="container">
    <h1 class="page__title page__title--popular">Популярное</h1>
</div>
<div class="popular container">
    <div class="popular__filters-wrapper">
        <div class="popular__sorting sorting">
            <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
            <ul class="popular__sorting-list sorting__list">
                <li class="sorting__item sorting__item--popular">
                    <a class="sorting__link  <?php if ($_GET['sort'] == ('popular') or $_GET['sort'] == ('')) {
                        print "sorting__link--active";} ?>" href="?sort=popular&content_type=<?=$_GET['content_type'] ?? 'all'?>"">
                        <span>Популярность</span>
                        <svg class="sorting__icon" width="10" height="12">
                            <use xlink:href="#icon-sort"></use>
                        </svg>
                    </a>
                </li>
                <li class="sorting__item">
                    <a class="sorting__link <? if ($_GET['sort'] == ('like_count')) {
                    print "sorting__link--active";} ?>" href="?sort=like_count&content_type=<?=$_GET['content_type'] ?? 'all'?>">
                        <span>Лайки</span>
                        <svg class="sorting__icon" width="10" height="12">
                            <use xlink:href="#icon-sort"></use>
                        </svg>
                    </a>
                </li>
                <li class="sorting__item <? if ($_GET['sort'] == ('date')) {
                print "sorting__link--active";} ?>">
                    <a class="sorting__link" href="?sort=date&content_type=<?=$_GET['content_type'] ?? 'all'?>">
                        <span>Дата</span>
                        <svg class="sorting__icon" width="10" height="12">
                            <use xlink:href="#icon-sort"></use>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
        <div class="popular__filters filters">
            <b class="popular__filters-caption filters__caption">Тип контента:</b>
            <ul class="popular__filters-list filters__list">


                <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
                    <a class="filters__button filters__button--ellipse filters__button--all <?php
                    if ($_GET['content_type'] == ('all') or $_GET['content_type'] == ('')) {
                        print "filters__button--active";
                    } ?> "
                       href="?sort=<?=$_GET['sort'] ?? 'popular'?>&content_type=all">
                        <span>Все</span>
                    </a>

                </li>
                <li class="popular__filters-item filters__item">
                    <a class="filters__button filters__button--photo button <?php
                    if ($_GET['content_type'] == 3) {
                        print "filters__button--active";
                    } ?>" href="?sort=<?=$_GET['sort'] ?? 'popular'?>&content_type=3">
                        <span class="visually-hidden">Фото</span>
                        <svg class="filters__icon" width="22" height="18">
                            <use xlink:href="#icon-filter-photo"></use>
                        </svg>
                    </a>
                </li>
                <li class="popular__filters-item filters__item">
                    <a class="filters__button filters__button--video button <?
                    if ($_GET['content_type'] == 4) {
                        print "filters__button--active";
                    } ?>" href="?sort=<?=$_GET['sort'] ?? 'popular'?>&content_type=4">
                        <span class="visually-hidden">Видео</span>
                        <svg class="filters__icon" width="24" height="16">
                            <use xlink:href="#icon-filter-video"></use>
                        </svg>
                    </a>
                </li>
                <li class="popular__filters-item filters__item">
                    <a class="filters__button filters__button--text button <?
                    if ($_GET['content_type'] == 1) {
                        print "filters__button--active";
                    } ?>" href="?sort=<?=$_GET['sort'] ?? 'popular'?>&content_type=1">
                        <span class="visually-hidden">Текст</span>
                        <svg class="filters__icon" width="20" height="21">
                            <use xlink:href="#icon-filter-text"></use>
                        </svg>
                    </a>
                </li>
                <li class="popular__filters-item filters__item">
                    <a class="filters__button filters__button--quote button <?
                    if ($_GET['content_type'] == 2) {
                        print "filters__button--active";
                    } ?>" href="?sort=<?=$_GET['sort'] ?? 'popular'?>&content_type=2">
                        <span class="visually-hidden">Цитата</span>
                        <svg class="filters__icon" width="21" height="20">
                            <use xlink:href="#icon-filter-quote"></use>
                        </svg>
                    </a>
                </li>
                <li class="popular__filters-item filters__item">
                    <a class="filters__button filters__button--link button <?
                    if ($_GET['content_type'] == 5) {
                        print "filters__button--active";
                    } ?>" href="?sort=<?=$_GET['sort'] ?? 'popular'?>&content_type=5">
                        <span class="visually-hidden">Ссылка</span>
                        <svg class="filters__icon" width="21" height="18">
                            <use xlink:href="#icon-filter-link"></use>
                        </svg>
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <div class="popular__posts">

        <?php
        foreach ($postListRows

        as $key => $val): ?>

        <article class="popular__post post <?= $val['icon_name'] ?>">
            <header class="post__header">
                <h2>
                    <a href="?post-id=<?= $val['post_num'] ?>">
                        <?= htmlspecialchars($val['header']) ?>

                    </a>
                </h2>
            </header>

            <div class="post__main">
                <?php
                if ($val['icon_name'] == "post-quote"): ?>

                    <div class="post-link__wrapper">
                        <a class="post-link__external" href="http://" title="Перейти по ссылке">
                            <div class="post-link__info-wrapper">
                                <div class="post-link__icon-wrapper">
                                    <img src="https://www.google.com/s2/favicons?domain=vitadental.ru"
                                         alt="Иконка">
                                </div>
                                <div class="post-link__info">
                                    <h3>
                                        <?= htmlspecialchars($val['header']) ?>

                                    </h3>
                                </div>
                            </div>
                            <span>
                                <?= htmlspecialchars($val['text_content']) ?>

                            </span>
                        </a>
                    </div>
                <?php
                elseif ($val['icon_name'] == "post-text"): ?>

                    <p>
                        <?= cutText(htmlspecialchars($val['text_content'])) ?>

                    </p>


                <?php
                elseif ($val['icon_name'] == "post-photo"): ?>

                    <div class="post-photo__image-wrapper">
                        <img src="<?= htmlspecialchars($val['media']) ?>" alt="Фото от пользователя" width="360"
                             height="240">
                    </div>

                <?php
                elseif ($val['icon_name'] == "post-link"): ?>

                    <div class="post-link__wrapper">
                        <a class="post-link__external" href="http://" title="Перейти по ссылке">
                            <div class="post-link__info-wrapper">
                                <div class="post-link__icon-wrapper">
                                    <img src="https://www.google.com/s2/favicons?domain=vitadental.ru"
                                         alt="Иконка">
                                </div>
                                <div class="post-link__info">
                                    <h3>
                                        <?= htmlspecialchars($val['header']) ?>

                                    </h3>
                                </div>
                            </div>
                            <span>
                                        <?= htmlspecialchars($val['text_content']) ?>

                            </span>
                        </a>
                    </div>
                <?php
                elseif ($val['icon_name'] == "post-video"): ?>

                <div class="post-video__preview">
                    <?= embed_youtube_cover($val['media']); ?>

                    <img src="img/coast-medium.jpg" alt="Превью к видео" width="360" height="188">
                </div>
                <a href="post-details.html" class="post-video__play-big button">
                    <svg class="post-video__play-big-icon" width="14" height="14">
                        <use xlink:href="#icon-video-play-big"></use>
                    </svg>
                    <span class="visually-hidden">Запустить проигрыватель</span>
                </a>
            </div>
            <?php
            endif ?>

    </div>
    <footer class="post__footer">
        <div class="post__author">
            <a class="post__author-link" href="#" title="Автор">
                <div class="post__avatar-wrapper">
                    <img class="post__author-avatar" src="<?= htmlspecialchars($val['avatar']) ?>"
                         alt="Аватар пользователя">
                </div>
                <div class="post__info">
                    <b class="post__author-name">
                        <?= htmlspecialchars($val['name']) ?>

                    </b>
                    <time title="<?= cutdate($val['create_date']) ?>" class="post__time"
                          datetime="<?= fullDate($val['create_date']) ?>"><?= smallDate($val['create_date']) ?></time>
                </div>
            </a>
        </div>
        <div class="post__indicators">
            <div class="post__buttons">
                <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                    <svg class="post__indicator-icon" width="20" height="17">
                        <use xlink:href="#icon-heart"></use>
                    </svg>
                    <svg class="post__indicator-icon post__indicator-icon--like-active" width="20"
                         height="17">
                        <use xlink:href="#icon-heart-active"></use>
                    </svg>
                    <span><?= $val['like-count'] ?></span>

                    <span class="visually-hidden">количество лайков</span>
                </a>
                <a class="post__indicator post__indicator--comments button" href="#"
                   title="Комментарии">
                    <svg class="post__indicator-icon" width="19" height="17">
                        <use xlink:href="#icon-comment"></use>
                    </svg>

                    <span><?= $val['comment-count'] ?></span>
                    <span class="visually-hidden">количество комментариев</span>

                </a>
            </div>
        </div>
    </footer>
    </article>
    <?php
    endforeach; ?>
</div>
</div>
