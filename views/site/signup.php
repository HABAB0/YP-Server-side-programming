<h2 class="signup-title">Регистрация нового пользователя</h2>
<h3 class="signup-message"><?= $message ?? ''; ?></h3>
<form method="post" class="signup-form">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label class="signup-form__label">Логин <input type="text" name="login" class="signup-form__input"></label>
    <label class="signup-form__label">Пароль <input type="password" name="password" class="signup-form__input"></label>
    <label class="signup-form__label" for="role_id">Роль пользователя:
        <select class="signup-form__input" name="role_id" id="role_id" required>
            <option value="1">Администратор</option>
            <option value="2" selected>Комендант</option>
        </select>
    </label>
    <button type="submit" class="signup-form__button">Зарегистрировать</button>
</form>