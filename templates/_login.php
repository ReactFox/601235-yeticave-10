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

<?php $classname = isset($errors) ? 'form--invalid' : '' ?>
<form class="form container" action="../login.php" method="post">
    <h2>Вход</h2>
    <?php $field_email_error = isset($errors['email']) ? 'form__item--invalid' : ''; ?>
    <div class="form__item <?= $field_email_error ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" value="<?= getPostVal('email') ?>" placeholder="Введите e-mail">
        <span class="form__error"><?= $errors['email'] ?></span>
    </div>

    <?php $field_pass_error = isset($errors['password']) ? 'form__item--invalid' : ''; ?>
    <div class="form__item form__item--last <?= $field_pass_error ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" value="<?= getPostVal('password') ?>" placeholder="Введите пароль">
        <span class="form__error"><?= $errors['password'] ?></span>
    </div>
    <button type="submit" class="button">Войти</button>
</form>