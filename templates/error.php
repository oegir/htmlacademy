<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category): ?>
            <li class="nav__item">
                <a href="<?=htmlspecialchars($category['symbol']);?>"><?=htmlspecialchars($category['title']);?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <section class="lot-item container">
        <h2>404 Страница не найдена</h2>
        <?php if (isset($errors)): ?>
             <?php foreach ($errors as $val): ?>
                <p><?= $val; ?></p>
             <?php endforeach; ?>
     <?php endif; ?>
    </section>
</main>
