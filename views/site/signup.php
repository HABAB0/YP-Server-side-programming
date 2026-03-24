<style>
    .signup-title {
        font-size: 28px;
        color: #333333;
        margin-bottom: 20px;
        border-bottom: 2px solid #d32f2f;
        padding-bottom: 10px;
        display: inline-block;
    }

    .signup-message {
        font-size: 18px;
        color: #d32f2f;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .signup-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .signup-form__label {
        display: flex;
        flex-direction: column;
        gap: 5px;
        font-weight: 600;
        color: #333333;
    }

    .signup-form__input {
        padding: 12px 15px;
        font-size: 16px;
        border: 2px solid #cccccc;
        border-radius: 4px;
        outline: none;
        transition: border-color 0.2s;
    }

    .signup-form__input:focus {
        border-color: #d32f2f;
    }

    .signup-form__button {
        display: flex;
        align-items: center;
        justify-content: center;
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

    .signup-form__button:hover {
        background-color: #f44336;
    }

    .signup-form__button:active {
        transform: scale(0.98);
        box-shadow: 0 2px 0 #9a0007;
    }
</style>

<h2 class="signup-title">Регистрация нового пользователя</h2>
<h3 class="signup-message"><?= $message ?? ''; ?></h3>
<form method="post" class="signup-form">
    <label class="signup-form__label">Имя <input type="text" name="name" class="signup-form__input"></label>
    <label class="signup-form__label">Логин <input type="text" name="login" class="signup-form__input"></label>
    <label class="signup-form__label">Пароль <input type="password" name="password" class="signup-form__input"></label>
    <button type="submit" class="signup-form__button">Зарегистрироваться</button>
</form>