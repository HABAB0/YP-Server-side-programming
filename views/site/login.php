<style>
    .login-title {
        font-size: 28px;
        color: #333333;
        margin-bottom: 20px;
        border-bottom: 2px solid #d32f2f;
        padding-bottom: 10px;
        display: inline-block;
    }

    .login-message {
        font-size: 18px;
        color: #d32f2f;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .login-user {
        font-size: 18px;
        color: #333333;
        margin-bottom: 20px;
    }

    .login-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .login-form__label {
        display: flex;
        flex-direction: column;
        gap: 5px;
        font-weight: 600;
        color: #333333;
    }

    .login-form__input {
        padding: 12px 15px;
        font-size: 16px;
        border: 2px solid #cccccc;
        border-radius: 4px;
        outline: none;
        transition: border-color 0.2s;
    }

    .login-form__input:focus {
        border-color: #d32f2f;
    }

    .login-form__button {
        background-color: #d32f2f;
        aspect-ratio: 1;
        color: #ffffff;
        font-size: 30px;
        font-weight: 700;
        padding: 100px;
        border: none;
        border-radius: 100%;
        cursor: pointer;
        letter-spacing: 1px;
        transition: background-color 0.2s, transform 0.1s;
        margin-top: 10px;
        box-shadow: 4px 7px 0 #9a0007;
    }

    .login-form__button:hover {
        background-color: #f44336;
    }

    .login-form__button:active {
        transform: scale(0.98);
        box-shadow: 0 2px 0 #9a0007;
    }
</style>

<h2 class="login-title">Авторизация</h2>
<h3 class="login-message"><?= $message ?? ''; ?></h3>

<h3 class="login-user"><?= app()->auth->user()->name ?? ''; ?></h3>
<?php
if (!app()->auth::check()):
    ?>
    <form method="post" class="login-form">
        <label class="login-form__label">Логин <input type="text" name="login" required class="login-form__input"></label>
        <label class="login-form__label">Пароль <input type="password" name="password" class="login-form__input"></label>
        <button type="submit" class="login-form__button">Войти</button>
    </form>
<?php endif;