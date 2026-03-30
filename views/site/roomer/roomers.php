<div class="rooms-header">
    <h1 class="rooms-title">Список жильцов</h1>
    <?php
    $user = app()->auth->user();
    if ($user && $user->role_id === 1):
        ?>
        <a href="<?= app()->route->getUrl('/roomers/create') ?>" class="rooms-add-link">Добавить жильца</a>
    <?php endif; ?>
</div>

<ol class="rooms-list">
    <?php if (empty($roomers)): ?>
        <li class="rooms-empty">Жильцов пока нет</li>
    <?php else: ?>
        <?php foreach ($roomers as $roomer): ?>
            <li class="rooms-list__item">
                <div class="rooms-list__info">
                    <?= $roomer->fio ?> - <?= $roomer->status ?>
                </div>
                <?php
                $user = app()->auth->user();
                if ($user && $user->role_id === 1):
                ?>
                <div class="rooms-list__actions">
                    <a href="<?= app()->route->getUrl('/roomers/edit/' . $roomer->id) ?>"
                       class="rooms-list__action rooms-list__action--edit">
                        Редактировать
                    </a>
                    <a href="<?= app()->route->getUrl('/roomers/delete/' . $roomer->id) ?>"
                       class="rooms-list__action rooms-list__action--delete">
                        Удалить жильца
                    </a>
                </div>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ol>