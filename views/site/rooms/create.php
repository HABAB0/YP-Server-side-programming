<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавление здания</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
<h2 class="signup-title">Добавление нового здания</h2>
<h3 class="signup-message"><?= $message ?? ''; ?></h3>
<form method="post" class="signup-form">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label class="signup-form__label">Название <input type="text" name="name" class="signup-form__input"></label>
    <label class="signup-form__label">Адрес <input type="text" name="address" class="signup-form__input"></label>
    <button type="submit" class="signup-form__button">Создать</button>
</form>
</body>
</html>