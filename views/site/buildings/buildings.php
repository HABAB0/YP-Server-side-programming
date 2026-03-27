<div class="buildings-header">
    <h1 class="buildings-title">Список Зданий</h1>
    <?php
    $user = app()->auth->user();
    if ($user && $user->role_id === 1):
        ?>
        <a href="<?= app()->route->getUrl('/buildings/create') ?>" class="buildings-add-link">Добавить здание</a>
    <?php endif; ?>
</div>

<ol class="buildings-list">
    <?php if (empty($buildings)): ?>
        <li class="buildings-empty">Зданий пока нет</li>
    <?php else: ?>
        <?php foreach ($buildings as $building): ?>
            <li class="buildings-list__item">
                <div class="buildings-list__info">
                    <strong><?= $building->name ?></strong> - по адресу: <?= $building->address ?>
                </div>
                <div class="buildings-list__actions">
                    <a href="<?= app()->route->getUrl('/buildings/edit/' . $building->id) ?>"
                       class="buildings-list__action buildings-list__action--edit">
                        Редактировать
                    </a>
                    <a href="<?= app()->route->getUrl('/buildings/delete/' . $building->id) ?>"
                       class="buildings-list__action buildings-list__action--delete">
                        Удалить здание
                    </a>
                </div>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ol>