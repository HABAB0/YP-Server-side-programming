
<h2 class="signup-title">Редактирование здания</h2>
<h3 class="signup-message"><?= $message ?? ''; ?></h3>
<form method="post" action=" <?= app()->route->getUrl('/edit/' . $building->id) ?>" class="signup-form">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label class="signup-form__label">Название <input type="text" name="name" class="signup-form__input" value="<?= $building->name ?>"></label>
    <label class="signup-form__label">Адрес <input type="text" name="address" class="signup-form__input" value="<?= $building->address ?>"></label>
    <button type="submit" class="signup-form__button">Изменить</button>
</form>