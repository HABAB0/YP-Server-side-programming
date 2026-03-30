<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавление комнаты</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
<h2 class="signup-title">Добавление новой комнаты</h2>
<h3 class="signup-message"><?= $message ?? ''; ?></h3>
<form method="post" class="signup-form">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label class="signup-form__label">
        ФИО
        <input type="text" name="room_number" class="signup-form__input"
               value="<?= $old['fio'] ?? '' ?>" required>
    </label>
    <label class="signup-form__label">
        Серия паспорта
        <input type="number" name="passport_series" class="signup-form__input"
               value="<?= $old['passport_series'] ?>" required>
    </label>
    <label class="signup-form__label">
        Номер пасспорта
        <input type="number" name="passport_number" class="signup-form__input"
               value="<?= $old['passport_number'] ?>" required>
    </label>
    <label class="signup-form__label">
        Номер пасспорта
        <input type="number" name="passport_number" class="signup-form__input"
               value="<?= $old['passport_number'] ?>" required>
    </label>
    <button type="submit" class="signup-form__button">Создать</button>
</form>
</body>
</html>