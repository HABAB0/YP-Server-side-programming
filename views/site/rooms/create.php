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
        Здание
        <select name="building_id" class="signup-form__input" required>
            <option value="">Выберите здание</option>
            <?php foreach ($buildings as $building): ?>
                <option value="<?= $building->id ?>" <?= ($old['building_id'] ?? '') == $building->id ? 'selected' : '' ?>>
                    <?= $building->name ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>
    <label class="signup-form__label">
        Номер комнаты
        <input type="text" name="room_number" class="signup-form__input"
               value="<?= $old['room_number'] ?? '' ?>" required>
    </label>
    <label class="signup-form__label">
        Вместимость
        <input type="number" name="capacity" class="signup-form__input"
               value="<?= $old['capacity'] ?? 1 ?>" min="1" required>
    </label>
    <label class="signup-form__label">
        Тип комнаты
        <select name="type" class="signup-form__input" required>
            <option value="male" <?= ($old['type'] ?? '') == 'male' ? 'selected' : '' ?>>Мужской</option>
            <option value="female" <?= ($old['type'] ?? '') == 'female' ? 'selected' : '' ?>>Женский</option>
        </select>
    </label>

    <button type="submit" class="signup-form__button">Создать</button>
</form>
</body>
</html>