<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и
        горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <!--заполните этот список из массива категорий-->
        <?php foreach ($categories as $item): ?>
            <li class="promo__item promo__item--<?php echo $item['symbolic_code'] ?>">
                <a class="promo__link"
                   href="all-lots.php?<?= $item['symbolic_code'] ?>"><?= htmlspecialchars($item['category_title'],
                        ENT_QUOTES | ENT_HTML5) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <!--заполните этот список из массива с товарами-->
        <?php foreach ($lots as $lot): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="../uploads/<?= htmlspecialchars($lot['lot_image'], ENT_QUOTES | ENT_HTML5) ?>" width="350"
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
