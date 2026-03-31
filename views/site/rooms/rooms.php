<div class="rooms-header">
    <h1 class="rooms-title">Список Комнат</h1>
    <?php
    $user = app()->auth->user();
    if ($user && $user->role_id === 1):
        ?>
        <a href="<?= app()->route->getUrl('/rooms/create') ?>" class="rooms-add-link">Добавить комнату</a>
    <?php endif; ?>
    <a href="<?= app()->route->getUrl('/rooms/available') ?>" class="rooms-add-link">Просмотр свободных комнат</a>
</div>

<ol class="rooms-list">
    <?php if (empty($rooms)): ?>
        <li class="rooms-empty">Комнат пока нет</li>
    <?php else: ?>
        <?php foreach ($rooms as $room): ?>
            <li class="rooms-list__item">
                <div class="rooms-list__info">
                    <?= $room->building->name ?? 'Без здания' ?> -
                    Комната №<?= $room->room_number ?>
                    (<?= $room->capacity ?> мест,
                    <?= $room->type == 'male' ? 'Мужская' : 'Женская' ?>)
                </div>
                <div class="rooms-list__actions">
                    <a href="<?= app()->route->getUrl('/rooms/edit/' . $room->id) ?>"
                       class="rooms-list__action rooms-list__action--edit">
                        Редактировать
                    </a>
                    <a href="<?= app()->route->getUrl('/rooms/delete/' . $room->id) ?>"
                       class="rooms-list__action rooms-list__action--delete">
                        Удалить комнату
                    </a>
                </div>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ol>