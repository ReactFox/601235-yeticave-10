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

<?php $classname = isset($errors) ? 'form--invalid' : '' ?>
<form class="form form--add-lot container <?= $classname ?>" action="../add.php" method="post"
      enctype="multipart/form-data">
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <?php $field_class_error = isset($errors['lot_title']) ? 'form__item--invalid' : ''; ?>
        <div class="form__item <?= $field_class_error ?>">
            <label for="lot-name">Наименование <sup>*</sup></label>
            <input id="lot-name" type="text" name="lot_title" value="<?= getPostVal('lot_title') ?>"
                   placeholder="Введите наименование лота">
            <span class="form__error"><?= $errors['lot_title'] ?></span>
        </div>

        <?php $form_class_error = isset($errors['category_id']) ? 'form__item--invalid' : ''; ?>
        <div class="form__item <?= $form_class_error ?>">
            <label for="category">Категория <sup>*</sup></label>

            <?php $selected = $_POST['category_id'] ?? '' ?>

            <select id="category" name="category_id">
                <option>Выберите категорию</option>

                <?php foreach ($categories as $item): ?>
                    <option value="<?= $item['id'] ?>" <?= ($selected === $item['id']) ? 'selected' : '' ?>> <?= htmlspecialchars($item['category_title'],
                            ENT_QUOTES | ENT_HTML5) ?></option>
                <?php endforeach; ?>

            </select>
            <span class="form__error"><?= $errors['category_id'] ?></span>
        </div>
    </div>

    <?php $form_textarea_error = isset($errors['lot_description']) ? 'form__item--invalid' : ''; ?>
    <div class="form__item form__item--wide <?= $form_textarea_error ?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="lot_description"
                  placeholder="Напишите описание лота"><?= getPostVal('lot_description') ?></textarea>
        <span class="form__error"><?= $errors['lot_description'] ?></span>
    </div>

    <?php $form_img_error = isset($errors['lot_image']) ? 'form__item--invalid' : ''; ?>
    <div class="form__item form__item--file <?= $form_img_error ?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="lot-img" name="lot_image">
            <label for="lot-img">
                Добавить
            </label>
        </div>
        <span class="form__error"><?= $errors['lot_image'] ?></span>
    </div>

    <div class="form__container-three">
        <?php $form_strprice_error = isset($errors['starting_price']) ? 'form__item--invalid' : ''; ?>
        <div class="form__item form__item--small <?= $form_strprice_error ?>">
            <label for="lot-rate">Начальная цена <sup>*</sup></label>
            <input id="lot-rate" type="text" name="starting_price" value="<?= getPostVal('starting_price') ?>"
                   placeholder="0">
            <span class="form__error"><?= $errors['starting_price'] ?></span>
        </div>

        <?php $form_stap_error = isset($errors['bet_step']) ? 'form__item--invalid' : ''; ?>
        <div class="form__item form__item--small <?= $form_stap_error ?>">
            <label for="lot-step">Шаг ставки <sup>*</sup></label>
            <input id="lot-step" type="text" name="bet_step" value="<?= getPostVal('bet_step') ?>" placeholder="0">
            <span class="form__error"><?= $errors['bet_step'] ?></span>
        </div>

        <?php $form_finish_error = isset($errors['date_finish']) ? 'form__item--invalid' : ''; ?>
        <div class="form__item <?= $form_finish_error ?>">
            <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
            <input class="form__input-date" id="lot-date" type="text" name="date_finish"
                   value="<?= getPostVal('date_finish') ?>"
                   placeholder="Введите дату в формате ГГГГ-ММ-ДД">
            <span class="form__error"><?= $errors['date_finish'] ?></span>
        </div>
    </div>

    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>
