<div>
    <h1>Список Зданий</h1>
    <?php
    $user = app()->auth->user();
    if ($user && $user->role_id === 1):
    ?>
        <a href="<?= app()->route->getUrl('/create') ?>" class="header__link">Добавить здание</a>
    <?php endif; ?>

</div>
<ol>
    <?php foreach ($buildings as $building): ?>
        <li>
            <?= $building->name ?> - по адресу: <?= $building->address ?>
            <a href="<?= app()->route->getUrl('/delete/' . $building->id) ?>">Удалить здание</a>
            <a href="<?= app()->route->getUrl('/edit/' . $building->id) ?>">Редактировать</a>
        </li>
    <?php endforeach; ?>
</ol>