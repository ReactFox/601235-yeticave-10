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
            <tr class="rates__item <?= get_status_user_bet($my_bet['date_finish'], $my_bet['winner_id']) ?>">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="../uploads/<?= htmlspecialchars($my_bet['lot_image'], ENT_QUOTES | ENT_HTML5) ?>"
                             width="54" height="40" alt="Крепления">
                    </div>
                    <div>
                        <h3 class="rates__title"><a
                                    href="lot.php?id=<?= $my_bet['lot_id'] ?>"><?= htmlspecialchars($my_bet['lot_title'],
                                    ENT_QUOTES | ENT_HTML5) ?></a></h3>
                        <?php if($my_bet['winner_id'] === $_SESSION['user']['id']): ?>
                        <p><?= htmlspecialchars($my_bet['contacts'],ENT_QUOTES | ENT_HTML5) ?></p>
                        <?php endif; ?>
                    </div>
                </td>
                <td class="rates__category">
                    <?= htmlspecialchars($my_bet['category_title'], ENT_QUOTES | ENT_HTML5) ?>
                </td>
                <td class="rates__timer">
                    <?php if ( (strtotime($my_bet['date_finish']) < time()) && ($my_bet['winner_id'] === null)): ?>
                        <div class="timer timer--end">Торги окончены</div>

                    <?php elseif (strtotime($my_bet['date_finish']) > time()): ?>
                        <?php $get_time = stop_time($my_bet['date_finish']) ?>
                        <div class="timer <?php if ($get_time[1] < '01'): ?>timer--finishing<?php endif; ?>">
                            <?= $get_time[1] . ':' . $get_time[2] ?>
                        </div>

                    <?php elseif ($my_bet['winner_id'] === $_SESSION['user']['id']): ?>
                        <div class="timer timer--win">Ставка выиграла</div>
                    <?php endif; ?>
                </td>
                <td class="rates__price">
                    <?= amount_formatting(htmlspecialchars($my_bet['max_my_bet'], ENT_QUOTES | ENT_HTML5), 0) ?> р
                </td>
                <td class="rates__time">
                    <?= get_relative_format($my_bet['date_bate']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>
