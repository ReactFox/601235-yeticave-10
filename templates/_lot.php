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
<section class="lot-item container">
    <h2><?= htmlspecialchars($lot['lot_title']) ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="../uploads/<?= htmlspecialchars($lot['lot_image']) ?>" width="730" height="548"
                     alt="Изображение: <?= htmlspecialchars($lot['lot_title']) ?>">
            </div>
            <p class="lot-item__category">Категория: <span><?= htmlspecialchars($lot['category_title']) ?></span></p>
            <p class="lot-item__description"><?= htmlspecialchars($lot['lot_description']) ?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">
                <?php $get_time = stop_time(htmlspecialchars($lot['date_finish'])) ?>
                <div class="lot-item__timer timer <?php if ($get_time[1] < '01'): ?>timer--finishing<?php endif; ?>">
                    <?= $get_time[1] . ':' . $get_time[2] ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?= amount_formatting(htmlspecialchars($sum_bet['sum_bet'])) ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?= htmlspecialchars($lot['bet_step'],
                                ENT_QUOTES | ENT_HTML5) . ' р' ?></span>
                    </div>
                </div>

                <?php $check_user_bet = false ?>
                <?php if (!count($history_users_bet)) {
                    $check_user_bet = true;
                } elseif ($history_users_bet[0]['user_id'] !== ($_SESSION['user']['id'] ?? 0)) {
                    $check_user_bet = true;
                } ?>

                <?php if (isset($_SESSION['user']) && ($lot['author_id'] !== $_SESSION['user']['id']) && (strtotime($lot['date_finish']) > time()) && $check_user_bet): ?>

                    <form class="lot-item__form" method="post"
                          autocomplete="off">
                        <?php $field_cost_error = isset($errors['cost']) ? 'form__item--invalid' : ''; ?>
                        <p class="lot-item__form-item form__item <?= $field_cost_error ?>">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="cost"
                                   placeholder="<?= amount_formatting(placeholder_format($sum_bet['sum_bet'],
                                       $lot['bet_step']), 0) ?>">
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
                                <td class="history__name"><?= htmlspecialchars($user_bet['user_name']) ?></td>
                                <td class="history__price"><?= htmlspecialchars(amount_formatting($user_bet['bet_amouth'],
                                        0)) . ' р' ?></td>
                                <td class="history__time"><?= htmlspecialchars( get_relative_format($user_bet['date_bet'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>