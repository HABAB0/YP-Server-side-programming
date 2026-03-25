<h2 class="login-title">Авторизация</h2>
<h3 class="login-message"><?= $message ?? ''; ?></h3>

<h3 class="login-user"><?= app()->auth->user()->name ?? ''; ?></h3>
<?php
if (!app()->auth::check()):
    ?>
    <form method="post" class="login-form">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <label class="login-form__label">Логин <input type="text" name="login" required class="login-form__input"></label>
        <label class="login-form__label">Пароль <input type="password" name="password" class="login-form__input"></label>
        <button type="submit" class="login-form__button">Войти</button>
    </form>
<?php endif;