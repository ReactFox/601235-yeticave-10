<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $item): ?>
            <li class="nav__item">
                <a href="all-lots.php?<?= $item['symbolic_code'] ?>"><?= htmlspecialchars($item['category_title'],
                        ENT_QUOTES | ENT_HTML5) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <?php foreach ($my_bets as $my_bet): ?>
            <!--        <tr class="rates__item">-->
            <!--            <td class="rates__info">-->
            <!--                <div class="rates__img">-->
            <!--                    <img src="../img/rate1.jpg" width="54" height="40" alt="Сноуборд">-->
            <!--                </div>-->
            <!--                <h3 class="rates__title"><a href="lot.html">2014 Rossignol District Snowboard</a></h3>-->
            <!--            </td>-->
            <!--            <td class="rates__category">-->
            <!--                Доски и лыжи-->
            <!--            </td>-->
            <!--            <td class="rates__timer">-->
            <!--                <div class="timer timer--finishing">07:13:34</div>-->
            <!--            </td>-->
            <!--            <td class="rates__price">-->
            <!--                10 999 р-->
            <!--            </td>-->
            <!--            <td class="rates__time">-->
            <!--                5 минут назад-->
            <!--            </td>-->
            <!--        </tr>-->
            <!--        <tr class="rates__item">-->
            <!--            <td class="rates__info">-->
            <!--                <div class="rates__img">-->
            <!--                    <img src="../img/rate2.jpg" width="54" height="40" alt="Сноуборд">-->
            <!--                </div>-->
            <!--                <h3 class="rates__title"><a href="lot.html">DC Ply Mens 2016/2017 Snowboard</a></h3>-->
            <!--            </td>-->
            <!--            <td class="rates__category">-->
            <!--                Доски и лыжи-->
            <!--            </td>-->
            <!--            <td class="rates__timer">-->
            <!--                <div class="timer timer--finishing">07:13:34</div>-->
            <!--            </td>-->
            <!--            <td class="rates__price">-->
            <!--                10 999 р-->
            <!--            </td>-->
            <!--            <td class="rates__time">-->
            <!--                20 минут назад-->
            <!--            </td>-->
            <!--        </tr>-->
            <tr class="rates__item">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="../uploads/<?= htmlspecialchars($my_bet['lot_image'], ENT_QUOTES | ENT_HTML5) ?>" width="54" height="40" alt="Крепления">
                    </div>
                    <div>
                        <h3 class="rates__title"><a href="lot.php?id=<?= $my_bet['lot_id'] ?>"><?= htmlspecialchars($my_bet['lot_title'],
                                    ENT_QUOTES | ENT_HTML5) ?></a></h3>
<!--                        <p>--><?//= htmlspecialchars($my_bet['contacts'],ENT_QUOTES | ENT_HTML5) ?><!--</p>-->
                    </div>
                </td>
                <td class="rates__category">
                    <?= htmlspecialchars($my_bet['category_title'],ENT_QUOTES | ENT_HTML5) ?>
                </td>
                <td class="rates__timer">
<!--                    <div class="timer timer--win">Ставка выиграла</div>-->

                    <?php $get_time = stop_time($my_bet['date_finish']) ?>
                    <!--TODO-->
                    <div class="timer <?php if ($get_time[1] < '01'): ?>timer--finishing<?php endif; ?>">
                        <?= $get_time[1] . ':' . $get_time[2] ?>
                    </div>

                </td>
                <td class="rates__price">
                    <?= amount_formatting(htmlspecialchars($my_bet['max_my_bet'],ENT_QUOTES | ENT_HTML5),0) ?> р
                </td>
                <td class="rates__time">
<!--                    --><?//= get_relative_format($my_bet['date_bet']) ?>
                    Час назад
                </td>
            </tr>
            <!--        <tr class="rates__item">-->
            <!--            <td class="rates__info">-->
            <!--                <div class="rates__img">-->
            <!--                    <img src="../img/rate4.jpg" width="54" height="40" alt="Ботинки">-->
            <!--                </div>-->
            <!--                <h3 class="rates__title"><a href="lot.html">Ботинки для сноуборда DC Mutiny Charocal</a></h3>-->
            <!--            </td>-->
            <!--            <td class="rates__category">-->
            <!--                Ботинки-->
            <!--            </td>-->
            <!--            <td class="rates__timer">-->
            <!--                <div class="timer">07:13:34</div>-->
            <!--            </td>-->
            <!--            <td class="rates__price">-->
            <!--                10 999 р-->
            <!--            </td>-->
            <!--            <td class="rates__time">-->
            <!--                Вчера, в 21:30-->
            <!--            </td>-->
            <!--        </tr>-->
            <!--        <tr class="rates__item rates__item--end">-->
            <!--            <td class="rates__info">-->
            <!--                <div class="rates__img">-->
            <!--                    <img src="../img/rate5.jpg" width="54" height="40" alt="Куртка">-->
            <!--                </div>-->
            <!--                <h3 class="rates__title"><a href="lot.html">Куртка для сноуборда DC Mutiny Charocal</a></h3>-->
            <!--            </td>-->
            <!--            <td class="rates__category">-->
            <!--                Одежда-->
            <!--            </td>-->
            <!--            <td class="rates__timer">-->
            <!--                <div class="timer timer--end">Торги окончены</div>-->
            <!--            </td>-->
            <!--            <td class="rates__price">-->
            <!--                10 999 р-->
            <!--            </td>-->
            <!--            <td class="rates__time">-->
            <!--                Вчера, в 21:30-->
            <!--            </td>-->
            <!--        </tr>-->
            <!--        <tr class="rates__item rates__item--end">-->
            <!--            <td class="rates__info">-->
            <!--                <div class="rates__img">-->
            <!--                    <img src="../img/rate6.jpg" width="54" height="40" alt="Маска">-->
            <!--                </div>-->
            <!--                <h3 class="rates__title"><a href="lot.html">Маска Oakley Canopy</a></h3>-->
            <!--            </td>-->
            <!--            <td class="rates__category">-->
            <!--                Разное-->
            <!--            </td>-->
            <!--            <td class="rates__timer">-->
            <!--                <div class="timer timer--end">Торги окончены</div>-->
            <!--            </td>-->
            <!--            <td class="rates__price">-->
            <!--                10 999 р-->
            <!--            </td>-->
            <!--            <td class="rates__time">-->
            <!--                19.03.17 в 08:21-->
            <!--            </td>-->
            <!--        </tr>-->
            <!--        <tr class="rates__item rates__item--end">-->
            <!--            <td class="rates__info">-->
            <!--                <div class="rates__img">-->
            <!--                    <img src="../img/rate7.jpg" width="54" height="40" alt="Сноуборд">-->
            <!--                </div>-->
            <!--                <h3 class="rates__title"><a href="lot.html">DC Ply Mens 2016/2017 Snowboard</a></h3>-->
            <!--            </td>-->
            <!--            <td class="rates__category">-->
            <!--                Доски и лыжи-->
            <!--            </td>-->
            <!--            <td class="rates__timer">-->
            <!--                <div class="timer timer--end">Торги окончены</div>-->
            <!--            </td>-->
            <!--            <td class="rates__price">-->
            <!--                10 999 р-->
            <!--            </td>-->
            <!--            <td class="rates__time">-->
            <!--                19.03.17 в 08:21-->
            <!--            </td>-->
            <!--        </tr>-->
        <?php endforeach; ?>
    </table>
    <!--rates__item  rates__item--end ставки оконченны-->
    <!--rates__item rates__item--win если победил -->
</section>
