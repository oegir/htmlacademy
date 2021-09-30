<div class="container">
    <h1 class="page__title page__title--popular">Популярное</h1>
</div>
<div class="popular container">
    <div class="popular__filters-wrapper">
        <div class="popular__sorting sorting">
            <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
            <ul class="popular__sorting-list sorting__list">
                <li class="sorting__item sorting__item--popular">
                    <a class="sorting__link  <?php
                    if ($_GET['sort'] == ('popular') or $_GET['sort'] == ('')) {
                        print "sorting__link--active";
                    } ?>" href="?sort=popular&content_type=<?= $_GET['content_type'] ?? 'all' ?>"">
                    <span>Популярность</span>
                    <svg class="sorting__icon" width="10" height="12">
                        <use xlink:href="#icon-sort"></use>
                    </svg>
                    </a>
                </li>
                <li class="sorting__item">
                    <a class="sorting__link <?
                    if ($_GET['sort'] == ('like_count')) {
                        print "sorting__link--active";
                    } ?>" href="?sort=like_count&content_type=<?= $_GET['content_type'] ?? 'all' ?>">
                        <span>Лайки</span>
                        <svg class="sorting__icon" width="10" height="12">
                            <use xlink:href="#icon-sort"></use>
                        </svg>
                    </a>
                </li>
                <li class="sorting__item <?
                if ($_GET['sort'] == ('date')) {
                    print "sorting__link--active";
                } ?>">
                    <a class="sorting__link" href="?sort=date&content_type=<?= $_GET['content_type'] ?? 'all' ?>">
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
                       href="?sort=<?= $_GET['sort'] ?? 'popular' ?>&content_type=all">
                        <span>Все</span>
                    </a>

                </li>
                <li class="popular__filters-item filters__item">
                    <a class="filters__button filters__button--photo button <?php
                    if ($_GET['content_type'] == 3) {
                        print "filters__button--active";
                    } ?>" href="?sort=<?= $_GET['sort'] ?? 'popular' ?>&content_type=3">
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
                    } ?>" href="?sort=<?= $_GET['sort'] ?? 'popular' ?>&content_type=4">
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
                    } ?>" href="?sort=<?= $_GET['sort'] ?? 'popular' ?>&content_type=1">
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
                    } ?>" href="?sort=<?= $_GET['sort'] ?? 'popular' ?>&content_type=2">
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
                    } ?>" href="?sort=<?= $_GET['sort'] ?? 'popular' ?>&content_type=5">
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

    <?= $post_content ?>

    </div>
</div>
