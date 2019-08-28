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

<?php $classname = isset($errors) ? 'form--invalid' : '' ?>
<form class="form form--add-lot container <?= $classname ?>" action="../add.php" method="post"
      enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <?php $field_class_error = isset($errors['lot_title']) ? 'form__item--invalid' : ''; ?>
        <div class="form__item <?= $field_class_error ?>"> <!-- form__item--invalid -->
            <label for="lot-name">Наименование <sup>*</sup></label>
            <input id="lot-name" type="text" name="lot_title" value="<?= getPostVal('lot_title') ?>"
                   placeholder="Введите наименование лота">
            <span class="form__error"><?= $errors['lot_title'] ?></span>
        </div>

        <?php $form_class_error = isset($errors['category_id']) ? 'form__item--invalid' : ''; ?>
        <div class="form__item <?= $field_class_error ?>">
            <label for="category">Категория <sup>*</sup></label>
            <select id="category" name="category_id">
                <option>Выберите категорию</option>

                <?php foreach ($categories as $item): ?>
                    <option value="<?= $item['id'] ?>"><?= htmlspecialchars($item['category_title'],
                            ENT_QUOTES | ENT_HTML5) ?></option>>
                <?php endforeach; ?>

                <span class="form__error">Выберите категорию</span>
            </select>
        </div>
    </div>

    <?php $form_textarea_error = isset($errors['lot_description']) ? 'form__item--invalid' : ''; ?>
    <div class="form__item form__item--wide <?= $form_textarea_error ?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="lot_description"
                  placeholder="Напишите описание лота"><?= getPostVal('lot_description') ?></textarea>
        <span class="form__error">Напишите описание лота</span>
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

        <?php $form_stap_error = isset($errors['bet_step'])? 'form__item--invalid': ''; ?>
        <div class="form__item form__item--small <?= $form_stap_error ?>">
            <label for="lot-step">Шаг ставки <sup>*</sup></label>
            <input id="lot-step" type="text" name="bet_step" value="<?= getPostVal('bet_step') ?>" placeholder="0">
            <span class="form__error">Введите шаг ставки</span>
        </div>

        <?php $form_finish_error = isset($errors['date_finish'])? 'form__item--invalid': ''; ?>
        <div class="form__item <?= $form_finish_error ?>">
            <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
            <input class="form__input-date" id="lot-date" type="text" name="date_finish"
                   value="<?= getPostVal('date_finish') ?>"
                   placeholder="Введите дату в формате ГГГГ-ММ-ДД">
            <span class="form__error">Введите дату завершения торгов</span>
        </div>
    </div>

    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>

<!--Отладочная запись-->
<?php
echo '<pre>';
print_r($_POST);
echo '</pre>';

echo '<pre>';
var_dump($_FILES);
echo '</pre>';
?>
