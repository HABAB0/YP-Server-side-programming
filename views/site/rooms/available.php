<h2 class="signup-title">Доступные комнаты</h2>
<h3>Мужские комнаты</h3>
<?php if (empty($maleRooms)): ?>
    <p>Нет свободных мужских комнат</p>
<?php else: ?>
    <ul class="rooms-list">
        <?php foreach ($maleRooms as $room): ?>
            <li class="rooms-list__item">
                Комната №<?= $room->room_number ?>
                <span>Свободно: <?= $room->capacity - $room->fullness ?> из <?= $room->capacity ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<h3>Женские комнаты</h3>
<?php if (empty($femaleRooms)): ?>
    <p>Нет свободных женских комнат</p>
<?php else: ?>
    <ul class="rooms-list">
        <?php foreach ($femaleRooms as $room): ?>
            <li class="rooms-list__item">
                Комната №<?= $room->room_number ?>
                <span>Свободно: <?= $room->capacity - $room->fullness ?> из <?= $room->capacity ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
