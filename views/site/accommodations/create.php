<h2 class="signup-title">Заселение жильца</h2>

<?php if (isset($errors) && !empty($errors)): ?>
    <div class="alert alert-error">
        <?php foreach ($errors as $field => $errorMessages): ?>
            <?php foreach ($errorMessages as $message): ?>
                <p><?= htmlspecialchars($message) ?></p>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post" action="/accommodations" class="signup-form">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>

    <label class="signup-form__label">
        Жилец
        <select name="roomer_id" class="signup-form__input <?= isset($errors['roomer_id']) ? 'input-error' : '' ?>" required>
            <option value="">Выберите жильца</option>
            <?php foreach ($roomers as $roomer): ?>
                <option value="<?= $roomer->id ?>" <?= ($roomer_id ?? $old['roomer_id'] ?? '') == $roomer->id ? 'selected' : '' ?>>
                    <?= $roomer->fio ?>
                    (<?= $roomer->passport_series ?> <?= $roomer->passport_number ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <label class="signup-form__label">
        Комната
        <select name="room_id" class="signup-form__input <?= isset($errors['room_id']) ? 'input-error' : '' ?>" required>
            <option value="">Выберите комнату</option>
            <?php foreach ($rooms as $room): ?>
                <?php
                $occupied = \Model\Accommodation::query()
                    ->where('room_id', $room->id)
                    ->where('status', 'active')
                    ->count();
                $available = $room->capacity - $occupied;
                ?>
                <option value="<?= $room->id ?>" <?= ($room_id ?? $old['room_id'] ?? '') == $room->id ? 'selected' : '' ?>>
                    №<?= $room->room_number ?>
                    (Свободно: <?= $available ?> из <?= $room->capacity ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <label class="signup-form__label">
        Дата заселения
        <input type="date" name="check_in_date" class="signup-form__input <?= isset($errors['check_in_date']) ? 'input-error' : '' ?>"
               value="<?= $old['check_in_date'] ?? date('Y-m-d') ?>" required>
    </label>

    <button type="submit" class="signup-form__button">Заселить</button>
</form>