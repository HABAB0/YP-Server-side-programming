<div class="rooms-header">
    <h1 class="rooms-title">Список жильцов</h1>
    <?php
    $user = app()->auth->user();
    if ($user && $user->role_id === 1):
        ?>
        <a href="<?= app()->route->getUrl('/roomers/create') ?>" class="rooms-add-link">Добавить жильца</a>
    <?php endif; ?>
</div>

<div class="search-form">
    <form method="GET" action="/roomers" class="search-form__form">
        <input
                type="text"
                name="search"
                class="search-form__input"
                placeholder="Поиск по ФИО..."
                value="<?= $search ?? '' ?>"
        >
        <button type="submit" class="search-form__button">Найти</button>
        <?php if (!empty($search)): ?>
            <a href="/roomers" class="search-form__clear">Сбросить</a>
        <?php endif; ?>
    </form>
</div>

<?php if (!empty($search)): ?>
    <div class="search-results">
        Найдено: <?= count($roomers) ?> жильцов(а)
    </div>
<?php endif; ?>

<ol class="rooms-list">
    <?php if (empty($roomers)): ?>
        <li class="rooms-empty">
            <?php if (!empty($search)): ?>
                Жильцы не найдены
            <?php else: ?>
                Жильцов пока нет
            <?php endif; ?>
        </li>
    <?php else: ?>
        <?php foreach ($roomers as $roomer): ?>
            <li class="rooms-list__item">
                <div class="rooms-list__info">
                    <?= $roomer->fio ?> - <?= $roomer->status == 'pending' ? 'В ожидании' : 'Заселён' ?>
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