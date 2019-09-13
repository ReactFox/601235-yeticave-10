<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $item): ?>
            <li class="nav__item">
                <a href="../pages/all-lots.html"><?= htmlspecialchars($item['category_title'],
                        ENT_QUOTES | ENT_HTML5) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<section class="lot-item container">
    <h2><?= $lot['lot_title'] ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="../uploads/<?= $lot['lot_image'] ?>" width="730" height="548"
                     alt="Изображение: <?= $lot['lot_title'] ?>">
            </div>
            <p class="lot-item__category">Категория: <span><?= $lot['category_title'] ?></span></p>
            <p class="lot-item__description"><?= $lot['lot_description'] ?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">
                <?php $get_time = stop_time($lot['date_finish']) ?>
                <div class="lot-item__timer timer <?php if ($get_time[1] < '01'): ?>timer--finishing<?php endif; ?>">
                    <!--10:54-->
                    <?= $get_time[1] . ':' . $get_time[2] ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?= amount_formatting($sum_bet['sum_bet']) ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?= htmlspecialchars($lot['bet_step'],
                                ENT_QUOTES | ENT_HTML5) . ' р' ?>  <!--12 000 р --></span>
                    </div>
                </div>
                <!--                отладочная запись-->
                <!--                --><?php //var_dump(($lot['date_finish'] < date('Y-m-d H:i:s'))) ?>
                <?php if ((isset($_SESSION['user']) && ($lot['author_id'] !== $_SESSION['user']['id'])) && !($lot['date_finish'] < date('Y-m-d H:i:s'))): ?>
                    <form class="lot-item__form" method="post"
                          autocomplete="off">
                        <?php $field_cost_error = isset($errors['cost']) ? 'form__item--invalid' : ''; ?>
                        <p class="lot-item__form-item form__item <?= $field_cost_error ?>">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="cost" placeholder="12 000">
                            <span class="form__error"><?= isset($errors['cost']) ? $errors['cost'] : '' ?></span>
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                <?php endif; ?>
            </div>
            <?php if (isset($_SESSION['user'])): ?>
                <div class="history">
                    <h3>История ставок (<span><?= $sum_bet['total_bet'] ?></span>)</h3>
                    <table class="history__list">
                        <?php foreach ($history_users_bet as $user_bet): ?>
                            <tr class="history__item">
                                <td class="history__name"><?= $user_bet['user_name'] ?></td>
                                <td class="history__price"><?= amount_formatting($user_bet['bet_amouth'],
                                        0) . ' р' ?></td>
                                <td class="history__time"><?= get_relative_format( $user_bet['date_bet'])  ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>