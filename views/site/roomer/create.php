<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавление жильца</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
<h2 class="signup-title">Добавление нового жильца</h2>
<h3 class="signup-message"><?= $message ?? ''; ?></h3>
<form method="post" class="signup-form">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label class="signup-form__label">
        ФИО
        <input type="text" name="fio" class="signup-form__input"
               value="<?= $old['fio'] ?? '' ?>" >
    </label>
    <label class="signup-form__label">
        Серия паспорта
        <input type="number" name="passport_series" class="signup-form__input"
               value="<?= $old['passport_series'] ?? '' ?>" >
    </label>
    <label class="signup-form__label">
        Номер пасспорта
        <input type="number" name="passport_number" class="signup-form__input"
               value="<?= $old['passport_number'] ?? '' ?>" >
    </label>
    <label class="signup-form__label">
        Номер приказа о заселении
        <input type="number" name="number_of_check_in" class="signup-form__input"
               value="<?= $old['number_of_check_in'] ?? '' ?>" >
    </label>
    <button type="submit" class="signup-form__button">Создать</button>
</form>
</body>
</html>