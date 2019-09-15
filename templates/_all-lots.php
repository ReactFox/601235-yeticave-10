<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $item): ?>
            <li class="nav__item">
                <a href="?<?= $item['symbolic_code'] ?>"><?= htmlspecialchars($item['category_title'],
                        ENT_QUOTES | ENT_HTML5) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<div class="container">
    <section class="lots">
        <h2>Все лоты в категории <span>«<?= htmlspecialchars($current_category['category_title']??'',
                    ENT_QUOTES | ENT_HTML5) ?>»</span></h2>
            <?php foreach ($lots as $lot): ?>
        <ul class="lots__list">
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="../uploads/<?= htmlspecialchars($lot['lot_image'], ENT_QUOTES | ENT_HTML5) ?>"
                             width="350"
                             height="260"
                             alt="Фото: <?= htmlspecialchars($lot['lot_title']), ENT_QUOTES | ENT_HTML5 ?>">
                    </div>
                    <div class="lot__info">
                    <span class="lot__category"><?= htmlspecialchars($lot['category_title'],
                            ENT_QUOTES | ENT_HTML5) ?></span>
                        <h3 class="lot__title"><a class="text-link"
                                                  href="lot.php?id=<?= $lot['id'] ?>"><?= htmlspecialchars($lot['lot_title'],
                                    ENT_QUOTES | ENT_HTML5) ?></a>
                        </h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= amount_formatting(htmlspecialchars($lot['starting_price'],
                                        ENT_QUOTES | ENT_HTML5)) ?></span>
                            </div>

                            <?php $get_time = stop_time($lot['date_finish']) ?>

                            <div class="lot__timer timer <?php if ($get_time[1] < '01'): ?>timer--finishing<?php endif; ?>">
                                <?= $get_time[1] . ':' . $get_time[2] ?>
                            </div>
                        </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <li class="pagination-item pagination-item-active"><a>1</a></li>
        <li class="pagination-item"><a href="#">2</a></li>
        <li class="pagination-item"><a href="#">3</a></li>
        <li class="pagination-item"><a href="#">4</a></li>
        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
    </ul>
</div>
