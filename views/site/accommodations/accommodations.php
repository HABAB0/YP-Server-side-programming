<h2 class="page-title">Поселения жильцов</h2>

<div class="accommodations-actions">
    <a href="/accommodations/create" class="btn btn-primary">Заселить жильца</a>
</div>

<h3 class="signup-message"><?= $message ?? ''; ?></h3>

<div class="accommodations-table-wrapper">
    <table class="table accommodations-table">
        <thead class="accommodations-table__tbody">
        <tr class="accommodations-table__row ">
            <th class="accommodations-table__header">Жилец</th>
            <th class="accommodations-table__header">Комната</th>
            <th class="accommodations-table__header">Заселение</th>
            <th class="accommodations-table__header">Выселение</th>
            <th class="accommodations-table__header">Дней</th>
            <th class="accommodations-table__header">Статус</th>
            <th class="accommodations-table__header">Действия</th>
        </tr>
        </thead>
        <tbody class="accommodations-table__tbody">
        <?php foreach ($accommodations as $acc): ?>
            <tr class="accommodations-table__row">
                <td class="accommodations-table__cell accommodation__info">
                    <span class="accommodation__name"><?= $acc->roomer->fio ?></span>
                    <span class="accommodation__passport"><?= $acc->roomer->passport_series ?> <?= $acc->roomer->passport_number ?></span>
                </td>
                <td class="accommodations-table__cell accommodation__info">
                    <span class="accommodation__room-number">№<?= $acc->room->room_number ?></span>
                    <span class="accommodation__room-type <?= $acc->room->type ?>">
                        <?= $acc->room->type === 'male' ? 'Мужская' : 'Женская' ?>
                    </span>
                </td>
                <td class="accommodations-table__cell accommodation__date">
                    <?= $acc->check_in_date ?>
                </td>
                <td class="accommodations-table__cell accommodation__date">
                    <?= $acc->check_out_date ?? '—' ?>
                </td>
                <td class="accommodations-table__cell accommodation__days">
                    <span class="badge badge-days"><?= $acc->getDaysCount() ?> дн.</span>
                </td>
                <td class="accommodations-table__cell accommodation__status">
                    <?php if ($acc->status === 'active'): ?>
                        <span class="status-badge status-active">Активно</span>
                    <?php else: ?>
                        <span class="status-badge status-checked-out">Выселен</span>
                    <?php endif; ?>
                </td>
                <td class="accommodations-table__cell accommodation__actions">
                    <?php if ($acc->status === 'active'): ?>
                        <a href="/accommodations/checkout/<?= $acc->id ?>"
                           class="btn btn-sm btn-danger accommodation__checkout-btn">
                            Выселить
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>