<div class="rooms-header">
    <h1 class="rooms-title">Список Комнат</h1>
    <?php
    $user = app()->auth->user();
    if ($user && $user->role_id === 1):
        ?>
        <a href="<?= app()->route->getUrl('/rooms/create') ?>" class="rooms-add-link">Добавить комнату</a>
    <?php endif; ?>
</div>

<ol class="rooms-list">
    <?php if (empty($rooms)): ?>
        <li class="rooms-empty">Комнат пока нет</li>
    <?php else: ?>
        <?php foreach ($rooms as $room): ?>
            <li class="rooms-list__item">
                <div class="rooms-list__info">
                    <strong><?= $room->building->name ?? 'Без здания' ?></strong> -
                    Комната №<?= $room->room_number ?>
                    (<?= $room->capacity ?> мест,
                    <?php
                    $types = [
                            'male' => 'Мужская',
                            'female' => 'Женская',
                    ];
                    echo $types[$room->type] ?? $room->type;
                    ?>)
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