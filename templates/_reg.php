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
<form class="form container <?= $classname ?>" action="../register.php" method="post" enctype="multipart/form-data"
      autocomplete="off">
    <h2>Регистрация нового аккаунта</h2>
    <?php $field_email_error = isset($errors['email']) ? 'form__item--invalid' : ''; ?>
    <div class="form__item <?= $field_email_error ?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail">
        <span class="form__error"><?= $errors['email'] ?></span>
    </div>

    <?php $field_pass_error = isset($errors['password']) ? 'form__item--invalid' : ''; ?>
    <div class="form__item <?= $field_pass_error ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error"><?= $errors['password'] ?></span>
    </div>

    <?php $field_name_error = isset($errors['user_name']) ? 'form__item--invalid' : ''; ?>
    <div class="form__item <?= $field_name_error ?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="user_name" placeholder="Введите имя">
        <span class="form__error"><?= $errors['user_name'] ?></span>
    </div>

    <?php $field_contacts_error = isset($errors['contacts']) ? 'form__item--invalid' : ''; ?>
    <div class="form__item <?= $field_contacts_error ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="contacts" placeholder="Напишите как с вами связаться"></textarea>
        <span class="form__error"><?= $errors['contacts'] ?></span>
    </div>

    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
</form>