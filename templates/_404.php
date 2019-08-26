<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $item): ?>
            <li class="nav__item">
                <a href="../pages/all-lots.html"><?= htmlspecialchars($item['category_title'],
                        ENT_QUOTES | ENT_HTML5) ?></a>
            </li>
        <?php endforeach; ?>

<!--        <li class="nav__item">-->
<!--            <a href="all-lots.html">Доски и лыжи</a>-->
<!--        </li>-->
<!--        <li class="nav__item">-->
<!--            <a href="all-lots.html">Крепления</a>-->
<!--        </li>-->
<!--        <li class="nav__item">-->
<!--            <a href="all-lots.html">Ботинки</a>-->
<!--        </li>-->
<!--        <li class="nav__item">-->
<!--            <a href="all-lots.html">Одежда</a>-->
<!--        </li>-->
<!--        <li class="nav__item">-->
<!--            <a href="all-lots.html">Инструменты</a>-->
<!--        </li>-->
<!--        <li class="nav__item">-->
<!--            <a href="all-lots.html">Разное</a>-->
<!--        </li>-->
    </ul>
</nav>

<section class="lot-item container">
    <h2>404 Страница не найдена</h2>
    <p>Данной страницы не существует на сайте.</p>
</section>